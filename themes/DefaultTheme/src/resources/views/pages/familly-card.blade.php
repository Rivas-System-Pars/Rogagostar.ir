@extends('front::layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ theme_asset('mapp/css/mapp.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('mapp/css/fa/style.css') }}">
@endpush

@push('meta')
    <link rel="canonical" href="{{ route('front.contact.index') }}" />
@endpush

@section('content')
    <!-- Start main-content -->
    <main class="main-content dt-sl mt-4 mb-3">
        <div class="container main-container">

            <div class="row">
                <div class="col-12">
                    <div class="page dt-sl dt-sn pt-3 pb-5 px-5">
                        <form  action="{{route('front.familly_card.store')}}" method="POST" class="p-4 border rounded shadow-sm bg-white">
                            @csrf
                           <h4 class="mb-4 font-weight-bold text-primary">فرم  اطلاعات مهندسان روگا گستر </h4>
   <p >مهندس عزیز سلام</p>
   <p>شرکت با درک درست جایگاه مهندسین در ارتقای کیفیت تأسیسات، به‌عنوان قلب تپنده ساختمان، با ابتکاری جدید شبکه همکاری مهندسین روگا گستر را به منظور تقدیر از زحمات شما عزیزان در حوزه اجرا و نظارت ساختمان راه‌اندازی نموده است.</p>
   <p>شما نیز با تکمیل اطلاعات زیر، از مزایای بن کارت هدیه خانواده روگا گستر بهره‌مند شوید.</p><br>

                            <div class="row">
                                {{-- موفقیت --}}
                                @if (session('success'))
                                    <div class="col-12 mb-3">
                                        <div class="alert alert-success text-center">{{ session('success') }}</div>
                                    </div>
                                @endif

                                {{-- نام --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">نام</label>
                                    <input type="text" name="first_name" value="{{ old('first_name') }}"
                                        class="form-control input-ui">
                                    @error('first_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- نام خانوادگی --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">نام خانوادگی</label>
                                    <input type="text" name="last_name" value="{{ old('last_name') }}"
                                        class="form-control input-ui">
                                    @error('last_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- شهر (لیست شهرها) --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"> شهر محل فعالیت</label>
                                    <select name="city_id" class="form-control input-ui">
                                        <option value="">انتخاب کنید...</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('city_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- نام فروشگاه --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">نام فروشگاه مد نظر </label>
                                    <input type="text" name="store_name" value="{{ old('store_name') }}"
                                        class="form-control input-ui">
                                    @error('store_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- شماره تماس --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">شماره تماس</label>
                                    <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                                        class="form-control input-ui">
                                    @error('phone_number')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- توضیحات --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">متراژ حدودی پروژه های درحال ساخت یا نظارت</label>
                                    <textarea name="description" rows="4" class="form-control input-ui">{{ old('description') }}</textarea>
                                    @error('description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <p class="text-danger">در صورت نیاز به اطلاعات بیشتر با شماره 09364115589 تماس بگیرید</p>

                                {{-- ارسال --}}
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-lg px-5">
                                        <i class="mdi mdi-send"></i> ارسال اطلاعات
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
