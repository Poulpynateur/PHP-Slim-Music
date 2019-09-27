@extends('layouts.app')

@section('content')

<nav class="nav flex-column" id="side_nav">
    @foreach ($categories as $category)
        <a class="nav-link flex-center side-bar-link p-0" href="#cat_id_{{ $category->id }}" data-cat="{{ $category->name }}"><span class="bar"></span></a>
    @endforeach
</nav>

<div class="container">
    @foreach ($categories as $category)
    <section id="cat_id_{{ $category->id }}">

        <h4 class="text-white" style="overflow:hidden;"><span class="text-primary">#</span>{{ $category->name }}</h4>

        <div class="pb-4">
        @foreach ($category->musics as $music)
            @include('layouts.music')
        @endforeach
        </div>

    </section>
    @endforeach
</div>
@endsection
