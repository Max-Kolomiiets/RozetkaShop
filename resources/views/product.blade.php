@extends('layouts.main')
@section('title', ' Популярні продукти')
@section('main_content')
    <div class="product-card">
        <h3 class="product-title">{{ $product_info->name }}</h3>
        <div class="products-info">
            <div class="left">
                <div class="preview">
                    <?php
                    $imagePath = $product_info->main_image->url;
                    if (strpos($imagePath, 'images') !== false) {
                        $imagePath = url('storage/' . $imagePath);
                    }
                    ?>

                    <div class="images">
                        <!-- Carousel wrapper -->
                        <div id="carouselIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel">
                            <!-- Slides -->
                            <div class="carousel-inner mb-5">
                                @foreach ($product_info->images as $image)
                                    <?php
                                    $subImagePath = $image['url'];
                                    if (strpos($subImagePath, 'images') !== false) {
                                        $subImagePath = url('storage/' . $subImagePath);
                                    }
                                    ?>

                                    @if ($loop->first)
                                        <div class="carousel-item active">
                                            <img src="{{ $subImagePath }}" class="d-block" />
                                        </div>
                                    @else
                                        <div class="carousel-item">
                                            <img src="{{ $subImagePath }}" class="d-block" />
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <!-- Slides -->

                            <!-- Controls -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                            <!-- Controls -->

                            <!-- Thumbnails -->
                            <div class="carousel-indicators" style="margin-bottom: -100px;">
                                @foreach ($product_info->images as $image)
                                    <li>
                                        <?php
                                        $sub2ImagePath = $image['url'];
                                        if (strpos($sub2ImagePath, 'images') !== false) {
                                            $sub2ImagePath = url('storage/' . $sub2ImagePath);
                                        }
                                        ?>

                                        @if ($loop->first)
                                            <button type="button" data-bs-target="#carouselIndicators"
                                                data-bs-slide-to="{{ $loop->index }}" class="active"
                                                aria-current="true" aria-label="Slide {{ $loop->index + 1 }}"
                                                style="width: 100px;">
                                                <img class="d-block img-fluid" src="{{ $sub2ImagePath }}" />
                                            </button>
                                        @else
                                            <button type="button" data-bs-target="#carouselIndicators"
                                                data-bs-slide-to="{{ $loop->index }}"
                                                aria-label="Slide {{ $loop->index + 1 }}" style="width: 100px;">
                                                <img class="d-block img-fluid" src="{{ $sub2ImagePath }}" />
                                            </button>
                                        @endif

                                    </li>
                                @endforeach
                            </div>
                            <!-- Thumbnails -->
                        </div>
                        <!-- Carousel wrapper -->
                    </div>
                </div>
            </div>
            <div class="right">
                <div class="details">
                    <div class="bay-section">
                        <h4 class="price"><span>{{ $product_info->price }} ₴</span></h4>
                        @if ($product_info->inCart)
                            <div class="product-already-in-cart-block">
                                <a href="{{ route('cart.index') }}" class="align-items-center product-already-in-cart">
                                    В кошику
                                </a>
                            </div>
                        @else
                            <div class="action feature">
                                <button class="bay-btn add-to-cart-btn" type="button">Купити</button>
                                <input type="hidden" class="product_id" value="{{ $product_info->id }}">
                                <!-- Your Product ID -->
                                <input type="hidden" class="qty-input" value="1">
                                {{-- <button class="like btn btn-default" type="button"><span class="fa fa-heart"></span></button> --}}
                            </div>
                        @endif
                    </div>
                    <div class="description">
                        <h3>Опис</h3>
                        <p class="product-description">
                            {{ $product_info->description }}
                        </p>
                    </div>

                    <div class="characteristic">
                        <h3>Характеристики</h3>
                        <div>
                            <table>
                                @foreach ($product_info->characteristics as $characteristic)
                                    <tr>
                                        <td class="characteristic-name">{{ $characteristic->name }}</td>
                                        <td>{{ $characteristic->value }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    {{-- <div class="rating">
                    <div class="stars">
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    </div>
                    <span class="review-no">41 reviews</span>
                </div> --}}
                    {{-- <p class="vote"><strong>91%</strong> of buyers enjoyed this product! <strong>(87 votes)</strong></p>
                <h5 class="sizes">sizes:
                    <span class="size" data-toggle="tooltip" title="small">s</span>
                    <span class="size" data-toggle="tooltip" title="medium">m</span>
                    <span class="size" data-toggle="tooltip" title="large">l</span>
                    <span class="size" data-toggle="tooltip" title="xtra large">xl</span>
                </h5>
                <h5 class="colors">colors:
                    <span class="color orange not-available" data-toggle="tooltip" title="Not In store"></span>
                    <span class="color green"></span>
                    <span class="color blue"></span>
                </h5> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
