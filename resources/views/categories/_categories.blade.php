@extends('layouts.main')
@section('title', 'Категории')
@section('main_content')

    <h1 class="text-center"> Категорії </h1>
    {{-- for tree categories --}}
    <div class="g-4 py-5 col">
        <ul class="">
            @foreach ($categories as $category)
                <li class="category_li">

                    <a class="category_li" href="{{ route('category.show', $category->id) }}">

                        <x-category-item :category="$category" />

                    </a>


                </li>
            @endforeach
        </ul>
    </div>


@endsection
