<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CustomerClub;

class CustomerClubController extends Controller
{
    public function index()
    {
		$products = Product::query()->published()->pluck('title','id');
        return view('front::pages.demo-request',compact('products'));
    }
	
public function store(Request $request)
{
    $request->validate([
        'first_name'         => 'required|string',
        'last_name'          => 'required|string',
        'sales_person'       => 'required|string',
        'mobile'             => ['required', 'regex:/^(?:98|\+98|0098|0)?9[0-9]{9}$/'],
        'area'               => 'required|string',
        'invoice_images'     => 'required|array|min:1',
        'invoice_images.*'   => 'image|mimes:jpg,jpeg,png|max:2048',
        'project_images'     => 'required|array|min:1',
        'project_images.*'   => 'image|mimes:jpg,jpeg,png|max:2048',
        'card_number'        => 'required|digits:16',
		'Operator_number'	=>	['required', 'regex:/^(?:98|\+98|0098|0)?9[0-9]{9}$/']
    ], [], [
        'first_name'         => 'نام',
        'last_name'          => 'نام خانوادگی',
        'sales_person'       => 'نماینده فروش',
        'mobile'             => 'شماره موبایل',
        'area'               => 'منطقه اجرا',
        'invoice_images'     => 'عکس‌های فاکتور',
        'invoice_images.*'   => 'هر عکس فاکتور',
        'project_images'     => 'عکس‌های پروژه',
        'project_images.*'   => 'هر عکس پروژه',
        'card_number'        => 'شماره کارت بانکی',
		'Operator_number'	=>	'شماره نماینده'
    ]);

    // ذخیره عکس‌های فاکتور
    $invoiceImagePaths = [];
    foreach ($request->file('invoice_images') as $image) {
        $invoiceImagePaths[] = $image->store('uploads/invoices', 'public');
    }

    // ذخیره عکس‌های پروژه
    $projectImagePaths = [];
    foreach ($request->file('project_images') as $image) {
        $projectImagePaths[] = $image->store('uploads/projects', 'public');
    }

    CustomerClub::create([
        'first_name'       => $request->first_name,
        'last_name'        => $request->last_name,
        'sales_person'     => $request->sales_person,
        'mobile'           => $request->mobile,
        'area'             => $request->area,
        'invoice_image'    => json_encode($invoiceImagePaths),
        'project_image'    => json_encode($projectImagePaths),
        'card_number'      => $request->card_number,
		'Operator_number'	=>	$request->Operator_number
    ]);

    return redirect()->route('front.CustomerClub.index')->with('success', 'اطلاعات با موفقیت ثبت شد');
}

}
