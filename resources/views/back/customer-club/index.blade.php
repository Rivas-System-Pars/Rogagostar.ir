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
                                    <li class="breadcrumb-item">لیست باشگاه مجریان
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">

                @if($customerclub->count())
                    <section class="card">
                        <div class="card-header">
                            <h4 class="card-title">لیست باشگاه مجریان</h4>
                        </div>
                        <div class="card-content" id="main-card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>نام</th>
												<th>نام خانوادگی</th>
												<th>نام نماینده فروش</th>
												<th>شماره تماس</th>
												<th>منطقه اجرا</th>
												<th>شماره کارت</th>
												<th>تاریخ ثبت</th>
												<th>مشاهده در</th>
                                                <th class="text-center">عملیات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customerclub as $item)
											<tr id="brand-{{ $item->id }}-tr">
                                                    <td>{{ $item->first_name }}</td>
												    <td>{{ $item->last_name }}</td>
                                                    <td>{{ $item->sales_person }}</td>
                                                    <td>{{ $item->mobile }}</td>
                                                    <td>{{ $item->area }}</td>
                                                    <td>{{ $item->card_number }}</td>
													<td>{{ jdate($item->created_at)->format('%d %B %Y') }}</td>
													<td>{{ $item->viewed_at ? jdate($item->viewed_at)->format('%d %B %Y') : "مشاهده نشده" }}</td>
                                                    <td class="text-center">
														<a href="{{ route('admin.CustomerClub.show',$item->id) }}" class="btn btn-success mr-1 waves-effect waves-light">مشاهده جزئیات</a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>

                @else
                    <section class="card">
                        <div class="card-header">
                            <h4 class="card-title">لیست باشگاه مشتریان</h4>
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
                {{ $customerclub->links() }}

            </div>
        </div>
    </div>

@endsection