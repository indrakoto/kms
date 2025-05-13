<div class="pdf-container">
    <iframe src="{{ asset($file) }}#toolbar=0" 
            style="width:100%; height:600px;" 
            frameborder="0">
    </iframe>
    <div class="text-center mt-2">
        <a href="{{ asset($file) }}" 
           class="btn btn-sm btn-primary" 
           download>
           <i class="fas fa-download"></i> Unduh PDF
        </a>
    </div>
</div>