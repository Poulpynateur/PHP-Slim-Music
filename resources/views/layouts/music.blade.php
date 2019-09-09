<div class="container px-0 flex-center music-container position-relative">

    <img class="thumbnail d-md-block d-none" src="{{ $music->getYoutubeThumbnail() }}">

    <div class="m-2 text">
        <p class="text-light mb-1"><a class="text-light" href="{{ $music->getYoutubeUrl() }}">{{ $music->title }}</a></p>
        <p class="text-secondary my-0 ">{{ $music->channel->name }}</p>
    </div>

    <p class="text-light ml-auto my-0">{{ $music->duration }}</p>

    @auth
    <button type="button" class="btn btn-link position-absolute text-secondary delete-music" style="top:0;right:0" data-toggle="modal" data-target="#modal_edit_music" value="{{ $music->id }}">
        <i class="far fa-trash-alt text-danger"></i>
    </button>
    @endauth
</div>
<hr class="m-0 border-secondary">