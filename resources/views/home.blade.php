@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="last-added py-1">

            <img class="w-100" src="{{ $last_added->getYoutubeThumbnailHD() }}">
            <div class="text text-hight-contrast">
                <h3 class="text-white">RECENTLY ADDED</h3>
                <a class="text-light" href="{{ $last_added->getYoutubeUrl() }}">{{ $last_added->title }}</a>
            </div>

        </div>
    </div>
    <div class="row d-flex" style="justify-content: center;">
    @foreach ($musics as $music)
        <a href="{{ $music->getYoutubeUrl() }}" title="{{ $music->title }}"><img src="{{ $music->getYoutubeThumbnailLow() }}"></a>
    @endforeach
    </div>
</div>
@endsection
