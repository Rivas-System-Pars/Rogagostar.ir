@extends('back.layouts.master')

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb no-border">
                                    <li class="breadcrumb-item">مدیریت</li>
                                    <li class="breadcrumb-item">لیست فرم‌های مهندسان</li>
                                    <li class="breadcrumb-item active">نمایش اطلاعات</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section class="card">
                    <div class="card-header">
                        <h4 class="card-title">جزئیات فرم ثبت‌شده</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-12 col-md-6 mb-2">
                                    <div>نام و نام خانوادگی</div>
                                    <div class="mt-1">{{ $famillycards->first_name }} {{ $famillycards->last_name }}</div>
                                </div>

                                <div class="col-12 col-md-6 mb-2">
                                    <div>شماره تماس</div>
                                    <div class="mt-1">{{ $famillycards->phone_number }}</div>
                                </div>

                                <div class="col-12 col-md-6 mb-2">
                                    <div>شهر</div>
                                    <div class="mt-1">{{ optional($famillycards->city)->name ?? '-' }}</div>
                                </div>

                                <div class="col-12 col-md-6 mb-2">
                                    <div>نام فروشگاه</div>
                                    <div class="mt-1">{{ $famillycards->store_name }}</div>
                                </div>

                                <div class="col-12 col-md-12 mb-2">
                                    <div>توضیحات</div>
                                    <div class="mt-1">{{ $famillycards->description ?? '---' }}</div>
                                </div>
<form action="{{ route('admin.counseling-form.destroy', $famillycards->id) }}" method="POST" onsubmit="return confirm('آیا مطمئن هستید؟')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">حذف</button>
</form>

                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
