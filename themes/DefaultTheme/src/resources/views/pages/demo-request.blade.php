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
<form action="{{ route('front.CustomerClub.store') }}" method="POST" enctype="multipart/form-data" class="p-4 border rounded shadow-sm bg-white">
    @csrf
    <h4 class="mb-4 font-weight-bold text-primary">فرم عضویت در باشگاه مجریان</h4>
	<p>با سلام
به منظور قدردانی از زحمات مجریان گرامی، تمامی پروژه هایی که با محصولات روگاگستر اجرا و مراحل آزمون ‌وتحویل آن به درستی انجام شده باشد،مشمول دریافت پاداش مستقیم از طرف ما خواهد شد. 
باسپاس
باشگاه مجریان روگاگستر.</p>
    <div class="row">

        @if(session('success'))
            <div class="col-12 mb-3">
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            </div>
        @endif

        {{-- نام --}}
        <div class="col-lg-6 mb-3">
            <label class="form-label">نام</label>
            <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control input-ui">
            @error('first_name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- نام خانوادگی --}}
        <div class="col-lg-6 mb-3">
            <label class="form-label">نام خانوادگی</label>
            <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control input-ui">
            @error('last_name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- نماینده فروش --}}
        <div class="col-lg-6 mb-3">
            <label class="form-label">نام نماینده فروش</label>
            <input type="text" name="sales_person" value="{{ old('sales_person') }}" class="form-control input-ui">
            @error('sales_person') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- موبایل --}}
        <div class="col-lg-6 mb-3">
            <label class="form-label">شماره موبایل</label>
            <input type="text" name="mobile" value="{{ old('mobile') }}" class="form-control input-ui">
            @error('mobile') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
		<div class="col-lg-6 mb-3">
            <label class="form-label"> شماره موبایل نماینده مجری</label>
            <input type="text" name="Operator_number" value="{{ old('Operator_number') }}" class="form-control input-ui">
            @error('mobile') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- منطقه اجرا --}}
        <div class="col-lg-6 mb-3">
            <label class="form-label">منطقه اجرا</label>
            <input type="text" name="area" value="{{ old('area') }}" class="form-control input-ui">
            @error('area') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- عکس‌های فاکتور --}}
        <div class="col-lg-6 mb-3">
            <label class="form-label">عکس‌های فاکتور (چندتایی)</label>
            <input type="file" name="invoice_images[]" multiple accept="image/*" class="form-control input-ui">
            @error('invoice_images') <small class="text-danger d-block">{{ $message }}</small> @enderror
            @foreach ($errors->get('invoice_images.*') as $messages)
                @foreach ($messages as $msg)
                    <small class="text-danger d-block">{{ $msg }}</small>
                @endforeach
            @endforeach
        </div>

        {{-- عکس‌های پروژه --}}
        <div class="col-12 mb-3">
            <label class="form-label">عکس‌های پروژه (چندتایی)</label>
            <input type="file" name="project_images[]" multiple accept="image/*" class="form-control input-ui">
            @error('project_images') <small class="text-danger d-block">{{ $message }}</small> @enderror
            @foreach ($errors->get('project_images.*') as $messages)
                @foreach ($messages as $msg)
                    <small class="text-danger d-block">{{ $msg }}</small>
                @endforeach
            @endforeach
        </div>

        {{-- شماره کارت بانکی --}}
        <div class="col-12 mb-4">
            <label class="form-label">شماره کارت بانکی</label>
            <input type="text" name="card_number" value="{{ old('card_number') }}" class="form-control input-ui">
            @error('card_number') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- دکمه ارسال --}}
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary btn-lg px-5">
                <i class="mdi mdi-send"></i> ارسال اطلاعات
            </button>
        </div>
    </div>
</form>


                         <div class="row row-deck">
                             <div class="col-md-4">
                                 <div class="contact_tile block">
                                     <span class="tiles__icon icon-location-pin"></span>
                                     <h6 class="tiles__title">آدرس </h6>
                                     <div class="tiles__content">
                                         <p>{{ option('info_address') }}</p>
                                     </div>
                                 </div>
                             </div>
                             <!-- end /.col-md-4 -->

                             <div class="col-md-4">
                                 <div class="contact_tile block">
                                     <span class="tiles__icon icon-earphones"></span>
                                     <h6 class="tiles__title">شماره تماس</h6>
                                     <div class="tiles__content">
                                         <p>{{ option('info_tel') }}</p>
                                     </div>
                                 </div>
                                 <!-- end /.contact_tile block -->
                             </div>
                             <!-- end /.col-md-4 -->

                             <div class="col-md-4">
                                 <div class="contact_tile block">
                                     <span class="tiles__icon icon-envelope-open"></span>
                                     <h6 class="tiles__title">آدرس ایمیل</h6>
                                     <div class="tiles__content">
                                         <p>{{ option('info_email') }}</p>
                                     </div>
                                 </div>
                                 <!-- end /.contact_tile -->
                             </div>
                             <!-- end /.col-md-4 -->
                         </div>
                     </div>
                 </div>
             </div>

         </div>
     </main>
 @endsection
