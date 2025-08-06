<div class="container mt-2" data-aos="fade-up" data-aos-duration="1000">

	<div class="Option_Card_Title mb-3 mb-md-4 mx-0 w-100">
        <div class="Option_Card_Right_Line"></div>
        <h3 class="Option_Card_Center_Line"> {{ $widget->option('title')}}</h3>
        <div class="Option_Card_Left_Line"></div>
    </div>
	
</div>	

<div class="container Counseling-section-container" data-aos="fade-up" data-aos-duration="1000">
	<div class="row mt-2 mb-5">
        <div class="col-2 d-flex justify-content-center align-items-center">
            <div class="Counseling-image-container">
                <img src="{{ theme_asset('images/MoshaverePattern.png') }}" alt="مشاوره و اجرای سامانه های تحت وب"
                    class="img-fluid Counseling-flipped-image Counseling-image">
            </div>
        </div>
        <div class="col-8 text-center mt-4">
			
           
            <div class="Counseling-buttons-container row gap-4">
				<p class= "col-12 fs-5 text-muted">
					جهت دریافت لیست قیمت با شماره های زیر تماس بگیرید
				</p>
				<div class="w-100 d-flex align-items-center justify-content-center row-gap-3 column-gap-4 flex-wrap">
               
					<a href="{{$widget->option('right_link')}}">
						<button class="btn btn-primary Counseling-custom-button m-0" style="font-size: 15px;font-weight: bold;">{{ $widget->option('right_title')}}</button>
					</a>
                {{-- <a href="{{$widget->option('center_link')}}">
					<button class="btn btn-primary Counseling-custom-button m-0" style="font-size: 14px;font-weight: bold;">{{ $widget->option('center_title')}}</button>
					</a> --}}
                
					<a href="{{$widget->option('left_link')}}">
						<button class="btn btn-primary Counseling-custom-button m-0" style="font-size: 15px;font-weight: bold;">{{ $widget->option('left_title')}}</button>
					</a>
			
				</div>
				</div>
        </div>
        <div class="col-2 d-flex justify-content-center align-items-center">
            <div class="Counseling-image-container">
                <img src="{{ theme_asset('images/MoshaverePattern.png') }}" alt="{{ $widget->option('title')}}" class="img-fluid Counseling-image">
            </div>
        </div>
    </div>
</div>
