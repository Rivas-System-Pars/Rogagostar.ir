@php
    $variables          = get_widget($widget);
    $coworker_sliders   = $variables['coworker_sliders'];
@endphp

<div class="container d-flex align-items-center justify-content-center flex-column py-5" data-aos="fade-up" data-aos-duration="1000">
    <div class="Option_Card_Title">
        <div class="Option_Card_Right_Line-1"></div>
        <h2 class="Option_Card_Center_Line">تاییدیه و افتخارات</h2>
        <div class="Option_Card_Left_Line-1"></div>
    </div>
    <!-- اسلایدر -->
    <div class="customers-slider swiper-container py-5 m-0">
        <div class="swiper-wrapper">
            @foreach ($coworker_sliders as $slider)
            <div class="swiper-slide">
                <img src="{{ $slider->image }}" alt="{{ $slider->title }}">
            </div>
            @endforeach
        </div>

        <!-- دکمه‌های ناوبری -->
        <div class="swiper-button-next customers-next"></div>
        <div class="swiper-button-prev customers-prev"></div>
    </div>
</div>
