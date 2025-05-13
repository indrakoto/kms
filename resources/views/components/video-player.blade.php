@if($embed)
    <div class="ratio ratio-16x9">
        {!! $embed !!}
    </div>
@else
    <video controls style="width:100%">
        <source src="{{ asset($file) }}" type="video/mp4">
        Browser Anda tidak mendukung tag video.
    </video>
@endif