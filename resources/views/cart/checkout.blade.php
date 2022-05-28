@extends('layouts.main')

@section('main_content')
    <h1 class="text-center">Making an order</h1>

    <div class="col-6">
        @auth
            <form class="form m-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" value="David">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Lastname</label>
                    <input type="text" class="form-control" value="Petric">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Patronymic</label>
                    <input type="text" class="form-control" value="Redaitfg">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Phone</label>
                    <input type="phone" class="form-control" value="+3809751452">
                </div>
            </form>
        @else
            <form class="form m-3">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control name">
                </div>
                <div class="form-group">
                    <label for="">Lastname</label>
                    <input type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Patronymic</label>
                    <input type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Phone</label>
                    <input type="phone" class="form-control">
                </div>
            </form>
        @endauth
    </div>

    <hr>
    <h4 class="text-center">Goods</h4>
    <div class="row">
        @foreach ($cart_data as $data)
            <?php
            $product_id = isset($data['product_id']) ? $data['product_id'] : $data['item_id'];
            $imagePath = $data['item_image'];
            if (strpos($imagePath, 'images') !== false) {
                $imagePath = url('storage/' . $imagePath);
            }
            ?>
            <div class="col-sm-3">
                <div class="card">
                    <a href="{{ route('product.show', $product_id) }}" class="">
                        <img class="card-img-top" width="100em" height="100em" src="{{ $imagePath }}" alt="">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">{{ $data['item_name'] }}</h5>
                        <p class="card-text">Count: {{ $data['item_quantity'] }}</p>
                        <p class="card-text">Price: <small class="text-muted">{{ $data['item_price'] / 100 }}
                                $</small></p>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    <div class="text-center">
        <button class="btn btn-success btn-checkout">Agree checkout!</button>
    </div>
@endsection
