@extends('layouts/main')
@section('main_content')
    <div class="row mt-3">
        <div class="col-md-3 ">
            <div class="list-group ">
                <a href="{{ route('cabinet.index') }}" class="list-group-item list-group-item-action">
                    <div>{{ $user->name }}</div>
                    <div>{{ $user->email }}</div>
                </a>
                <a href="{{ route('cabinet.orders') }}" class="list-group-item list-group-item-action active">My orders</a>
                <a href="{{ route('cabinet.wishlist') }}" class="list-group-item list-group-item-action">Wish List</a>
                <a href="{{ route('cart.index') }}" class="list-group-item list-group-item-action">Cart</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text-center">Orders</h4>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @if (!$orders->isEmpty())
                                @foreach ($orders as $order)
                                    <h3>#{{ $order->order_number }}</h3>
                                    <h5>Status: <span
                                            class="text-success">{{ $order->orderStatus()->get()[0]->status }}</span></h5>
                                    <hr>
                                    <h5 class="text-center">Products:</h5>

                                    @foreach ($order->products()->get() as $orderProduct)
                                        <div class="border mt-3 mb-3 p-4">
                                            <h4>Product name: {{ $orderProduct->product()->get()[0]->name }}</h4>
                                            <h4>Count: {{ $orderProduct->qty }}</h4>
                                        </div>
                                    @endforeach
                                    <hr class="mb-3">
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
