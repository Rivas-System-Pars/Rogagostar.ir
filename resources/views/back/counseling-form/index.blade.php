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
                                    <li class="breadcrumb-item">مدیریت
                                    </li>
                                    <li class="breadcrumb-item"> لیست خانواده مهندسین 
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">

                @if($famillycards->count())
                    <section class="card">
                        <div class="card-header">
                            <h4 class="card-title"> لیست خانواده مهندسین</h4>
                        </div>
                        <div class="card-content" id="main-card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                    <tr>
                        <th>نام</th>
                        <th>نام خانوادگی</th>
                        <th>شهر فعالیت</th>
                        <th>شماره تماس</th>
                        <th>نام فروشگاه مورد نظر</th>
                        <th>تاریخ ثبت</th>
                        <th>مشاهده</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($famillycards as $item)
                        <tr>
                            <td>{{ $item->first_name }}</td>
                            <td>{{ $item->last_name }}</td>
                            <td>{{ optional($item->city)->name ?? '-' }}</td>
                            <td>{{ $item->phone_number }}</td>
                            <td>{{ $item->store_name }}</td>
                            <td>{{ jdate($item->created_at)->format('%d %B %Y') }}</td>
                            <td>
    														<a href="{{ route('admin.counseling-form.show',$item->id) }}" class="btn btn-success mr-1 waves-effect waves-light">مشاهده جزئیات</a>
                            </td>
                        </tr>
                    @endforeach
                    @if($famillycards->isEmpty())
                        <tr><td colspan="7">موردی برای نمایش وجود ندارد.</td></tr>
                    @endif
                </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>

                @else
                    <section class="card">
                        <div class="card-header">
                            <h4 class="card-title">لیست درخواست های مشاوره خرید</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="card-text">
                                    <p>چیزی برای نمایش وجود ندارد!</p>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif
                {{ $famillycards->links() }}

            </div>
        </div>
    </div>
@endsection
