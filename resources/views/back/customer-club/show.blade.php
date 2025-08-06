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
                                <li class="breadcrumb-item">لیست باشگاه مجریان</li>
                                <li class="breadcrumb-item">باشگاه مجریان</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            <section class="card">
                <div class="card-header">
                    <h4 class="card-title">باشگاه مجریان</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-12 col-md-6 mb-2">
                                <div>نام</div>
                                <div class="mt-1">{{ $customerclubItem->first_name }}</div>
                            </div>

                            <div class="col-12 col-md-6 mb-2">
                                <div>نام خانوادگی</div>
                                <div class="mt-1">{{ $customerclubItem->last_name }}</div>
                            </div>

                            <div class="col-12 col-md-6 mb-2">
                                <div>شماره تماس</div>
                                <div class="mt-1">{{ $customerclubItem->mobile }}</div>
                            </div>

                            <div class="col-12 col-md-6 mb-2">
                                <div>نام نماینده فروش</div>
                                <div class="mt-1">{{ $customerclubItem->sales_person }}</div>
                            </div>
							
							<div class="col-12 col-md-6 mb-2">
                                <div>شماره نماینده مجری</div>
                                <div class="mt-1">{{ $customerclubItem->Operator_number }}</div>
                            </div>

                            <div class="col-12 col-md-6 mb-2">
                                <div>منطقه اجرا</div>
                                <div class="mt-1">{{ $customerclubItem->area }}</div>
                            </div>

                            <div class="col-12 col-md-6 mb-2">
                                <div>شماره کارت</div>
                                <div class="mt-1">{{ $customerclubItem->card_number }}</div>
                            </div>

                            {{-- عکس‌های فاکتور --}}
                            <div class="col-12 col-md-6 mb-2">
                                <div>عکس‌های فاکتور</div>
                                <div class="mt-1 d-flex flex-wrap">
                                    @foreach(json_decode($customerclubItem->invoice_image, true) ?? [] as $path)
                                        <a href="{{ asset($path) }}" target="_blank" class="mr-1 mb-1">
                                            <img src="{{ asset($path) }}" alt="invoice" style="max-width: 100px; border-radius: 8px; box-shadow: 0 0 4px rgba(0,0,0,0.2);">
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            {{-- عکس‌های پروژه --}}
                            <div class="col-12 col-md-6 mb-2">
                                <div>عکس‌های پروژه</div>
                                <div class="mt-1 d-flex flex-wrap">
                                    @foreach(json_decode($customerclubItem->project_image, true) ?? [] as $path)
                                        <a href="{{ asset($path) }}" target="_blank" class="mr-1 mb-1">
                                            <img src="{{ asset($path) }}" alt="project" style="max-width: 100px; border-radius: 8px; box-shadow: 0 0 4px rgba(0,0,0,0.2);">
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                        </div> {{-- row --}}
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
