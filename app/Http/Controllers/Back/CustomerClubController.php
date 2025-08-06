<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\CustomerClub;
use Illuminate\Http\Request;

class CustomerClubController extends Controller
{
	public function __construct()
    {
        $this->middleware('can:demo-request');
    }
	
    public function index()
    {
        $customerclub  = CustomerClub::latest()->paginate(10);
        return view('back.customer-club.index', compact('customerclub'));
    }
	
	public function show($id)
    {
        $customerclubItem  = CustomerClub::findOrFail($id);
		if(is_null($customerclubItem->viewed_at)) $customerclubItem->update(['viewed_at'=>now()]);
        return view('back.customer-club.show', compact('customerclubItem'));
    }
}
