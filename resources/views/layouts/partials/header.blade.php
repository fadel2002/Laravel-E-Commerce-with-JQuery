<!-- Page Preloder -->
<div id="preloder">
    <div class="loader"></div>
</div>

<!-- Humberger Begin -->
<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
        <a><img src="{{asset('img/logo.png')}}" alt="logo" width="100px"></a>
    </div>
    <div class="humberger__menu__cart">
        <ul>
            <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
            <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
        </ul>
        <div class="header__cart__price">item: <span id="span-humberger-total-transaksi" class="span-total-transaksi">Rp
                {{$data['total_transaksi']}}</span></div>
    </div>
    <div class="humberger__menu__widget">
        <div class="header__top__right__auth">
            @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit();"><i
                        class="fa fa-user"></i> Logout</a>
            </form>
            @else
            <a href="{{route('login')}}"><i class="fa fa-user"></i> Login</a>
            @endauth
        </div>
    </div>
    <nav class="humberger__menu__nav mobile-menu">
        <ul>
            <li class="active"><a href="{{route('home')}}">Home</a></li>
            <li><a href="{{route('shop.index')}}">Shop</a></li>
            <li><a href="#">Pages</a>
                <ul class="header__menu__dropdown">
                    <li><a href="{{route('chat.index')}}">Chat</a></li>
                    <li><a href="{{route('shop.cart')}}">Shoping Cart</a></li>
                    <li><a href="{{route('shop.checkout')}}">Check Out</a></li>
                    <li><a href="{{route('history.index')}}">History</a></li>
                </ul>
            </li>
            @if(auth()->check() && auth()->user()->tipe_user == 2)
            <li><a href="#">Admin</a>
                <ul class="header__menu__dropdown">
                    <li><a href="{{route('admin.index')}}">Produk</a></li>
                    <li><a href="{{route('admin.transaksi')}}">Transaksi</a></li>
                </ul>
            </li>
            @endif
            <li><a href="{{route('contact')}}">Contact</a></li>
        </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    <div class="header__top__right__social">
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-linkedin"></i></a>
        <a href="#"><i class="fa fa-pinterest-p"></i></a>
    </div>
    <div class="humberger__menu__contact">
        <ul>
            <li><i class="fa fa-envelope"></i>{{$data['admin']['email']}}</li>
            <li>Free Shipping for all Order of $99</li>
        </ul>
    </div>
</div>
<!-- Humberger End -->

<!-- Header Section Begin -->
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__left">
                        <ul>
                            <li><i class="fa fa-envelope"></i>{{$data['admin']['email']}}</li>
                            <li>Free Shipping for all Order of $99</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__right">
                        <div class="header__top__right__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-pinterest-p"></i></a>
                        </div>
                        <div class="header__top__right__auth">
                            @auth
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{route('logout')}}"
                                    onclick="event.preventDefault(); this.closest('form').submit();"><i
                                        class="fa fa-user"></i> Logout</a>
                            </form>
                            @else
                            <a href="{{route('login')}}"><i class="fa fa-user"></i> Login</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="header__logo">
                    <a><img src="{{asset('img/logo.png')}}" alt="logo" width="60px"></a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="header__menu">
                    <ul>
                        <li id="btn-menu" class="home-menu"><a href="{{route('home')}}">Home</a></li>
                        <li id="btn-menu" class="shop-menu"><a href="{{route('shop.index')}}">Shop</a></li>
                        <li id="btn-menu" class="pages-menu"><a href="#">Pages</a>
                            <ul class="header__menu__dropdown">
                                <li id="btn-menu"><a href="{{route('chat.index')}}">Chat</a></li>
                                <li id="btn-menu"><a href="{{route('shop.cart')}}">Shoping Cart</a></li>
                                <li id="btn-menu"><a href="{{route('shop.checkout')}}">Check Out</a></li>
                                <li id="btn-menu"><a href="{{route('history.index')}}">History</a></li>
                            </ul>
                        </li>
                        @if(auth()->check() && auth()->user()->tipe_user == 2)
                        <li id="btn-menu" class="admin-menu"><a href="#">Admin</a>
                            <ul class="header__menu__dropdown">
                                <li id="btn-menu"><a href="{{route('admin.index')}}">Produk</a></li>
                                <li id="btn-menu"><a href="{{route('admin.transaksi')}}">Transaksi</a></li>
                            </ul>
                        </li>
                        @endif
                        <li class="contact-menu"><a href="{{route('contact')}}">Contact</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__cart">
                    <ul>
                        <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                        <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
                    </ul>
                    <div class="header__cart__price">item: <span id="span-header-total-transaksi"
                            class="span-total-transaksi">Rp
                            {{$data['total_transaksi']}}</span></div>
                </div>
            </div>
        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
<!-- Header Section End -->

<!-- Hero Section Begin -->
@if (Route::is('shop.index') || Route::is('shop.select-categories'))
<section class="hero hero-normal">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>All Categories</span>
                    </div>
                    <ul>
                        <form class="my-2" action="{{route('shop.select-categories')}}">
                            @csrf
                            <input type="hidden" name="kategori" value="*">
                            <li><button style="border: none; background-color: white">All</button></li>
                        </form>
                        @foreach($data['kategori'] as $kategori)
                        <form class="my-2" action="{{route('shop.select-categories')}}">
                            @csrf
                            <input type="hidden" name="kategori" value="{{$kategori}}">
                            <li><button style="border: none; background-color: white">{{ $kategori }}</button></li>
                        </form>
                        @endforeach
                        @error('kategori')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        {{-- <form action="{{route('search')}}"> --}}
                        <form>
                            @csrf
                            {{-- <input id="search" type="text" name="search" placeholder="What do yo u need?"> --}}
                            <input type="text" name="search" placeholder="What do yo u need?">
                            <input type="hidden" name="oldSearch" value="">
                            <input type="hidden" name="oldKategori" value="{{$data['current_kategori']}}">
                            {{-- <button type="submit" class="site-btn">SEARCH</button> --}}
                            <button type="submit" id="ajax-search" class="site-btn">SEARCH</button>

                            @error('search')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <a href="tel:{{$data['admin']['no_telp']}}"><i class="fa fa-phone text-success"></i></a>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>{{$data['admin']['no_telp']}}</h5>
                            <span>support 24/7 time</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- Hero Section End -->