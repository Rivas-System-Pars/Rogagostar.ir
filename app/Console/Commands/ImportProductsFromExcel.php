<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Product;
use App\Models\Category;
use App\Models\Price;
use Illuminate\Support\Str;

class ImportProductsFromExcel extends Command
{
    protected $signature = 'import:products {file="storage/app/product.xlsx"}';
    protected $description = 'وارد کردن محصولات + دسته‌بندی + قیمت از فایل اکسل با Eloquent';

    public function handle()
    {
        $filePath = $this->argument('file');

        if (!file_exists($filePath)) {
            $this->error("❌ فایل پیدا نشد: {$filePath}");
            return 1;
        }

        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        unset($rows[1]); // حذف عنوان ستون‌ها

        foreach ($rows as $row) {
            $mainTitle = trim($row['B'] ?? null);
            $subTitle = trim($row['C'] ?? null);
            $nameRaw = trim($row['D'] ?? 'محصول بدون نام');
            $size = trim($row['E'] ?? null);
            $amount = trim($row['F'] ?? null);
            $code = trim($row['G'] ?? null);

            $fullName = $code ? "$nameRaw $code" : $nameRaw;

            // ------------------------------
            // دسته‌بندی اصلی (اگر وجود نداشت ساخته میشه)
            $mainCategory = null;
            if ($mainTitle) {
                $mainCategory = Category::firstOrCreate([
                    'title' => $mainTitle
                ], [
                    'slug' => Str::slug($mainTitle),
                    'type' => 'productcat',
                    'published' => 1
                ]);
            }

            // ------------------------------
            // زیر دسته (با ارتباط به دسته اصلی)
            $finalCategory = $mainCategory;
            if ($subTitle) {
                $finalCategory = Category::firstOrCreate([
                    'title' => $subTitle
                ], [
                    'slug' => Str::slug($subTitle),
                    'type' => 'productcat',
                    'published' => 1,
                    'category_id' => $mainCategory?->id
                ]);
            }

            // ------------------------------
            // ساخت محصول
            $product = Product::create([
                'title' => $fullName,
                'slug' => Str::slug($fullName),
                'type' => 'product',
                'category_id' => $finalCategory?->id,
                'unit' => 'تعداد',
                'weight' => is_numeric($amount) ? (int) $amount : null,
                'published' => 1,
            ]);

            // ------------------------------
            // اتصال به دسته‌بندی (many-to-many)
            if ($finalCategory) {
                $product->categories()->attach($finalCategory->id);
            } else {
                $this->warn("⚠️no cat : {$product->title}");
            }

            // ------------------------------
            // ثبت قیمت پایه در جدول prices
            $product->price()->create([
                'price' => 1,
                'discount' => null,
                'discount_price' => null,
                'stock' => 1
            ]);

            $this->info("✅ done : «{$product->title}»");
        }

        $this->info("🎉 عملیات وارد کردن محصولات با موفقیت به پایان رسید.");
        return 0;
    }
}
