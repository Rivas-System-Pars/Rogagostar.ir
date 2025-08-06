<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\FamCard;
use Illuminate\Http\Request;

class FamillyCardController extends Controller
{
    public function index()
    {
        $cities = City::all();
    return view('front::pages.familly-card', compact('cities'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'city_id'        => 'required|exists:cities,id',
            'description'    => 'nullable|string',
            'store_name'     => 'required|string|max:255',
            'phone_number'   => ['required', 'regex:/^(?:98|\+98|0098|0)?9[0-9]{9}$/'],
        ], [], [
            'first_name'     => 'نام',
            'last_name'      => 'نام خانوادگی',
            'city_id'        => 'شهر',
            'description'    => 'توضیحات',
            'store_name'     => 'نام فروشگاه',
            'phone_number'   => 'شماره تماس',
        ]);

        FamCard::create([
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'city_id'      => $request->city_id,
            'description'  => $request->description,
            'store_name'   => $request->store_name,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('front.familly-card.index')->with('success', 'اطلاعات با موفقیت ثبت شد');
    }


}
