@php
    //echo $getRecord()->source->name;
    if(strtolower($getRecord()->source->name)=='pdf') {
        echo $getRecord()->file_path;
        //$path = Storage::disk('public')->url($getRecord()->file_path);
        //echo $path;
        //echo '<iframe src="'. $path .'" width="100%" height="500px"></iframe>';
    } elseif (strtolower($getRecord()->source->name)=='youtube') {
        echo $getRecord()->content;
    }
@endphp