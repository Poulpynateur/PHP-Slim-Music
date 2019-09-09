@extends('layouts.app')

@section('content')

<nav class="nav flex-column" id="side_nav">
    @foreach ($categories as $cat_id => $category)
        <a class="nav-link flex-center side-bar-link p-0" href="#cat_id_{{ $cat_id }}" data-cat="{{ $category['name'] }}"><span class="bar"></span></a>

        <nav class="nav flex-column">
            @if(!$category['musics']['active']->isEmpty())
            <a class="nav-link flex-center sub-side-bar-link p-0" href="#cat_active_id_{{ $cat_id }}" data-tag="ACTIVE"><span class="bar"></span></a>
            @endif
        
            @if(!$category['musics']['passive']->isEmpty())
            <a class="nav-link flex-center sub-side-bar-link p-0" href="#cat_passive_id_{{ $cat_id }}" data-tag="PASSIVE"><span class="bar"></span></a>
            @endif
        </nav>
        
    @endforeach
</nav>

<div class="container">
    @foreach ($categories as $cat_id => $category)
    <section id="cat_id_{{ $cat_id }}">

        <h4 class="text-white" style="overflow:hidden;"><span class="text-primary">#</span>{{ $category['name'] }}</h4>

        @if(!$category['musics']['active']->isEmpty())
        <div class="pb-4" id="cat_active_id_{{ $cat_id }}">
            @foreach ($category['musics']['active'] as $music)
                @include('layouts.music')
            @endforeach
        </div>
        @endif

        @if(!$category['musics']['passive']->isEmpty())
        <div class="pb-4" id="cat_passive_id_{{ $cat_id }}">
            @foreach ($category['musics']['passive'] as $music)
                @include('layouts.music')
            @endforeach
        </div>
        @endif

    </section>
    @endforeach
</div>
@endsection
