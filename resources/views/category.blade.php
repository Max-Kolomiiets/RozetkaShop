@extends('layouts.main')
@section('main_content')
    <div>
        <div><h1>{{$category->name}}</h1></div>
        <div>
            @foreach($subcategories as $subcategory)
                <div>
                    <img src="https://myrusakov.ru/images/articles/html_placeholder_02.jpg">
                </div>
                <div>
                    <a href="#">{{$subcategory->name}}</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection