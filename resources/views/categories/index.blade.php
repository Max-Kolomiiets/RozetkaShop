@extends('layouts.main')
@section('main_content')

 <h1 class="text-center"> Категорії </h1>

  <div class="g-4 py-5 col">
    <ul class="">
      @foreach ($categories as $category)
        <li class="category_li">
          <a class="category_li"
            href="{{ route('category.show', $category->id) }}">
          {{ $category->name }}
          </a>
        </li>
      @endforeach
    </ul>
  </div>
 
@endsection