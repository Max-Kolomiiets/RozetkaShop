@extends('layouts/main')
@section('main_content')
    <div class="row mt-3">
        <div class="col-md-3 ">
            <div class="list-group ">
                <a href="{{route("cabinet.index")}}" class="list-group-item list-group-item-action active">
                    <div>{{ $user->name }}</div> 
                    <div>{{ $user->email }}</div>
                </a>
                <a href="{{route("cabinet.orders")}}" class="list-group-item list-group-item-action">My orders</a>
                <a href="{{route("cabinet.wishlist")}}" class="list-group-item list-group-item-action">Wish List</a>
                <a href="{{route("cart.index")}}" class="list-group-item list-group-item-action">Cart</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Your Profile</h4>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <form>
                                <div class="form-group row">
                                    <label for="username" class="col-4 col-form-label">User Name*</label>
                                    <div class="col-8">
                                        <div class="form-control here">{{$user->name}}</div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <form action="{{ url('/logout') }}" method="post">
            @csrf
            <button class="btn btn-danger headers-links">Вийти</button>
        </form>
    </div>
@endsection
