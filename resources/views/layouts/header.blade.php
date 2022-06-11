{{-- @csrf --}}
{{-- <input class="form-control search-field header-word" name="word" type="text" onchange="this.form.submit()" placeholder="Я шукаю..."> --}}
{{-- <nav class="navbar navbar-expand navbar-dark header-background">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02"
        aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample02">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active mr-3">
                <a href="/" class="navbar-left" style="display: flex">
                    <img class="main-icon" src="{{ asset('icons/main-icon.png') }}">
                    <h5 class="text-light logo-titel">Укрмаркет</h5>
                </a>
            </li>
            @auth
            <li>
                <a class="navbar-brand headers-links" href="{{ route('cabinet.index') }}">Кабінет</a>
            </li>
            @endauth
            <li>
                <a class="nav-link headers-links" href="{{ route('cart.index') }}">Кошик</a>
            </li>
            <li>
                <span class="nav-item basket-item-count nav-link">
                </span>
            </li>
            <li class="nav-item active">
                <a class="nav-link headers-links" 
                href="{{ route('category.index') }}">
                Категорії 
                <span class="sr-only headers-links">(current)</span></a>
            </li>
        </ul>
    <form class="form-inline my-2 my-md-0" method="get" action="{{route('products.search')}}">
        
        <input class="search-component header-word" name="word" type="text" onchange="this.form.submit()" placeholder="Я шукаю...">
    </form>
    </div>
    @if (Route::has('login'))
        <div class="ml-3">
            @auth
                <form action="{{ url('/logout') }}" method="post">
                    @csrf
                    <button class="btn btn-danger headers-links">Вийти</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline headers-links">Увійти</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline headers-links">Зареєстркватись</a>
                @endif
            @endauth
        </div>
    @endif
</nav> --}}
<div>
    <nav class="navbar navbar-expand navbar-dark header-background">
        <div id="header-layout">
            <div id="layout-logo">
                <a href="/" id="logo" class="d-inline-flex">
                    <img class="main-icon" src="{{ asset('icons/main-icon.png') }}">
                    <h4>Укрмаркет</h4>
                </a>
            </div>
            <div id="layout-categories">
                <a href="{{ route('category.index') }}" id="categories">
                    Категорії
                </a>
            </div>
            <div id="layout-search">
                <form id="search" class="d-inline-flex" method="get" action="{{ route('products.search') }}">
                    <input class="search-input" name="word" type="text" onsubmit="this.form.submit()"
                        placeholder="Я шукаю...">
                    <input class="search-button" type="submit" value="Найти">
                </form>
            </div>
            <div id="layout-actions">
                <div id="actions" class="d-inline-flex">
                    <a id="cart" href="{{ route('cart.index') }}" class="icon-link align-items-center">
                        <span class="nav-item basket-item-count nav-link cart-item-count">
                        </span>
                        <div id="cart-icon">
                            <img src="{{ asset('icons/cart.png') }}" alt="cart">
                            {{-- <object id="cart-svg" 
                                data="{{asset('icons/cart.svg')}}" 
                                type="image/svg+xml" 
                                width="32" 
                                height="32"></object>
                            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" version="1.1">
                                <use xlink:href="cart.svg#cart"/>
                            </svg> --}}
                        </div>
                    </a>
                <a id="profile" @auth href="{{ route('cabinet.index') }}" @else href="{{ route('login') }}"
                    @endauth class="icon-link align-items-center">
                    <div id="profile-icon">
                        <img src="{{ asset('icons/profile.png') }}" alt="cart">
                        {{-- <object id="profile-svg" 
                                data="{{asset('icons/profile.svg')}}" 
                                type="image/svg+xml" 
                                width="32" 
                                height="32"></object>
                            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" version="1.1">
                                <use xlink:href="profile.svg#profile"/>
                            </svg> --}}
                    </div>
                </a>
            </div>
        </div>
    </div>
</nav>
</div>
