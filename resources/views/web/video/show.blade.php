@extends('web.layouts.app')

@section('content')
    <div class="video-page">
        <div class="main-video">
            <h3>{{ $video->title }}</h3>
            <div class="embed-responsive">
                <iframe src="{{ $signedUrl }}" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
            </div>
        </div>

        <div class="playlist-sidebar">
            <h4>قائمة التشغيل - {{ $video->level->title }}</h4>
            <ul>
                @foreach ($playlist as $vid)
                    <li class="{{ $vid->id == $video->id ? 'active' : '' }}">
                        <a href="{{ route('video.show', $vid) }}">{{ $vid->title }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
