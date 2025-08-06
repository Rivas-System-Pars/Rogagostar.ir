<nav class="main-menu dt-sl row g-0">
    <ul class="list float-right hidden-md col-lg-10">
        @foreach($menus as $menu)
            @include('front::partials.menu.child-menu')
        @endforeach

    </ul>
	
	 @include('front::partials.mobile-menu.menu')
	
    <ul class="nav float-left nav_direction p-0 col-11 card_direction col-lg-2">
        @include('front::partials.cart')
    </ul>

   
</nav>
