@extends('layouts.app')

@section('content')

<div class="container">

    <section class="my-5">
        <h2 class="text-white" style="overflow:hidden;">Favorites channels</h2>
        @foreach ($favorites as $channel)
        <h4 class="text-white" style="overflow:hidden;"><span class="text-primary">#</span>{{ $channel->name }}</h4>  
        @endforeach
    </section>

    @foreach ($all as $channel)
    <section class="my-5">

        <h4 class="text-white" style="overflow:hidden;"><span class="text-primary">#</span>{{ $channel->name }}</h4>
        <hr class="m-0 border-secondary">
        @foreach ($channel->musics as $music)
            @include('layouts.music')
        @endforeach
        
    </section>
    @endforeach
</div>
@endsection
