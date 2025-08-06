<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\FamCard;
use Illuminate\Http\Request;

class CounselingFormController extends Controller
{
	public function __construct()
    {
        $this->middleware('can:counseling-form');
    }
	
    public function index()
    {
        $famillycards = FamCard::latest()->paginate(10);
        return view('back.counseling-form.index', compact('famillycards'));
    }
	
	public function show($id)
    {
        $famillycards = FamCard::findOrFail($id);
		if(is_null($famillycards->viewed_at)) $famillycards->update(['viewed_at'=>now()]);
        return view('back.counseling-form.show', compact('famillycards'));
    }

	public function destroy($id)
	{
    $famillycard = FamCard::findOrFail($id);
    $famillycard->delete();

    return redirect()->route('admin.back.counseling-form.index')->with('success', 'با موفقیت حذف شد.');	}
}
