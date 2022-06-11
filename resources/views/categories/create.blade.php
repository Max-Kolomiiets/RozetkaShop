@extends('layouts.main')
@section('title', 'Категории')
@section('main_content')

    <div class="conteiner">
        <form action="{{ route(category . store) }} " method="post">
            @csrf

            @include('categories._form')
        </form>
    </div>

@endsection
