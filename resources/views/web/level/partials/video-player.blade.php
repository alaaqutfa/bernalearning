@props(['video'])

<div class="relative pb-[56.25%] h-0 overflow-hidden">
    @isset($signedUrl)
        <iframe src="{{ $signedUrl }}" class="absolute top-0 left-0 w-full h-full" frameborder="0"
            allow="autoplay; fullscreen" allowfullscreen>
        </iframe>
    @endisset
</div>
