@extends('layouts/main')
@section('main_content')
    <div class="row">
        <div class="col-md-3 ">
            <div class="list-group ">
                <a href="{{route("cabinet.index")}}" class="list-group-item list-group-item-action">
                    <div>{{ $user->name }}</div> 
                    <div>{{ $user->email }}</div>
                </a>
                <a href="{{route("cabinet.orders")}}" class="list-group-item list-group-item-action active">My orders</a>
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
                            @if (!$orders->isEmpty())
                                @foreach ($orders as $order)
                                    @foreach ($order->products() as $product)
                                        <p>$product->name</p>
                                    @endforeach
                                @endforeach
                            @else
                                <p>No orders yet!</p>
                            @endif
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection