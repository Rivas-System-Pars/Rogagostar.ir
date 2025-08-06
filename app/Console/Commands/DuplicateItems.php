<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DuplicateItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'duplicate:items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Duplicate all rows in items table with modification';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
		$items = DB::table('product_specification')->where('product_id',68)->get();
		
    foreach ($items as $item) {
        // ساخت یک ردیف جدید به صورت دستی
        $newItemData = (array) $item;
		unset($newItemData['id']);
        $newItemData['product_id'] = 86;

        // ذخیره ردیف جدید در جدول
        DB::table('product_specification')->insert($newItemData);
    }

    $this->info('Rows duplicated successfully.');
    return Command::SUCCESS;
    }
}
