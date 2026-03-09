@extends('layouts.app')

@section('content')
<div class="level-container">
    <h2>{{ $level->title }}</h2>
    <p>{{ $level->description }}</p>

    <div class="video-list">
        <h3>جميع فيديوهات المستوى</h3>
        <ul>
            @foreach($videos as $video)
            <li>
                <a href="{{ route('video.show', $video) }}">{{ $video->title }}</a>
            </li>
            @endforeach
        </ul>
    </div>

    <!-- عرض أول فيديو كمشغل افتراضي (اختياري) -->
    @if($videos->isNotEmpty())
        <div class="current-video">
            @include('partials.video-player', ['video' => $videos->first()])
        </div>
    @endif
</div>
@endsection
