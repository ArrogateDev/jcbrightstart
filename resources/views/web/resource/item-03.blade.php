@props(['resource' => null])
@php
    $embed_url = $resource->short;
    // Convert YouTube watch URL to embed URL
    if (str_contains($embed_url, 'youtube.com/watch?v=') || str_contains($embed_url, 'youtu.be/')) {
        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $embed_url, $matches);
        if (isset($matches[1])) {
            $embed_url = 'https://www.youtube.com/embed/' . $matches[1];
        }
    }
@endphp
<div class="col-span-12 md:col-span-4">
    <div class="bg-[#d8d4cf57] rounded-lg p-[21px]">
        <a class="block bg-[#fff] rounded-lg p-[14px_21px]" href="{{$resource->url}}">
            <div class="w-full overflow-hidden rounded-lg">
                <iframe class="w-full h-auto rounded-lg" src="{{$embed_url}}" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="text-[21px] text-[#00A99D] mt-[18px] h-[63px] line-clamp-2">{{$resource->title}}</div>
        </a>
    </div>
</div>
