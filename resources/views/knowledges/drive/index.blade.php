@extends('layouts.app')

@section('title', 'KMS - Knowledge Drive')

@section('content')
<section id="knowledge-drive" class="section">
    <div class="container">
        <div class="d-flex justify-content-between mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" id="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#" onclick="loadFolder()" class="text-decoration-none">
                            <i class="bi bi-house-door"></i> Root
                        </a>
                    </li>
                </ol>
            </nav>
            <button class="btn btn-sm btn-outline-secondary" onclick="goBack()" id="backButton" style="display:none;">
                <i class="bi bi-arrow-left"></i> Back
            </button>
        </div>

        <div id="loading" class="text-center my-5 py-5">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3 fs-5">Loading files...</p>
        </div>

        <div id="file-list" class="row g-3"></div>

        <div id="empty-state" class="text-center py-5" style="display: none;">
            <i class="bi bi-folder-x" style="font-size: 3rem;"></i>
            <h5 class="mt-3">No files found</h5>
        </div>

        <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="previewTitle">Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center p-0">
                        <div id="previewLoading" class="d-flex flex-column justify-content-center py-5" style="min-height: 60vh;">
                            <div class="spinner-border mx-auto" style="width: 3rem; height: 3rem;"></div>
                            <p class="mt-3">Loading preview...</p>
                        </div>
                        <div id="previewContainer" style="height: 70vh; overflow: auto;">
                            <!-- Dynamic content will be inserted here -->
                        </div>
                        <div id="unsupportedFile" class="alert alert-warning m-3" style="display: none;">
                            <i class="bi bi-exclamation-triangle"></i> Preview not available for this file type
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a id="downloadButton" href="#" class="btn btn-primary" download>
                            <i class="bi bi-download"></i> Download
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
    /* File Browser Styles */
    .file-item {
        animation: fadeIn 0.4s ease-out forwards;
        opacity: 0;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .file-item:hover {
        transform: translateY(-3px) !important;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }

    .file-icon {
        transition: transform 0.2s;
        font-size: 2.5rem;
    }

    .file-item:hover .file-icon {
        transform: scale(1.1);
    }

    /* Animation */
    @keyframes fadeIn {
        from { 
            opacity: 0;
            transform: translateY(-10px);
        }
        to { 
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Preview Container */
    #previewContainer {
        min-height: 500px;
        position: relative;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .file-item {
            animation-duration: 0.3s;
        }
        
        #file-list {
            gap: 0.5rem;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let currentFolder = null;
    let folderStack = [];

    $(document).ready(function() {
        loadFolder();
    });

    function loadFolder(folderId = null) {
        // Update history
        if (folderId && folderId !== currentFolder) {
            folderStack.push(currentFolder);
            $('#backButton').show();
        } else if (!folderId) {
            $('#backButton').hide();
        }

        $('#loading').show();
        $('#file-list').empty().hide();
        $('#empty-state').hide();

        $.ajax({
            url: '{{ route("knowledge.drive.list") }}',
            data: { folderId },
            success: function(data) {
                currentFolder = folderId;
                
                if (data.length === 0) {
                    $('#empty-state').show();
                } else {
                    renderFiles(data);
                    updateBreadcrumb(folderId);
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseJSON);
                $('#empty-state').show().find('h5').text('Error loading files');
            },
            complete: function() {
                $('#loading').hide();
                $('#file-list').fadeIn(300);
            }
        });
    }

    function renderFiles(files) {
        const $fileList = $('#file-list');
        
        files.forEach((file, index) => {
            const clickHandler = file.type === 'dir' 
                ? `loadFolder('${file.id}')` 
                : `previewFile(${JSON.stringify(file)})`;
            
            const fileHtml = `
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card file-item h-100 border-0 shadow-sm" 
                         onclick="${clickHandler}"
                         style="animation-delay: ${index * 50}ms">
                        <div class="card-body text-center p-3">
                            <div class="file-icon mb-2">${file.icon}</div>
                            <h6 class="card-title text-truncate mb-1">${file.name}</h6>
                            <small class="text-muted d-block">${file.modified}</small>
                            ${file.size ? `<small class="text-muted">${file.size}</small>` : ''}
                        </div>
                    </div>
                </div>
            `;
            $fileList.append(fileHtml);
        });
    }

    function previewFile(file) {
        const modal = new bootstrap.Modal('#previewModal');
        const $container = $('#previewContainer');
        const ext = file.name.split('.').pop()?.toLowerCase() || '';

        $('#previewLoading').show();
        $container.empty();
        $('#unsupportedFile').hide();
        $('#previewTitle').text(file.name);
        $('#downloadButton').attr('href', `{{ route('knowledge.drive.download', '') }}/${file.id}`);

        // Handle different file types
        if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
            $container.html(`<img src="{{ route('knowledge.drive.preview', '') }}/${file.id}" 
                              class="img-fluid" style="max-height:70vh;">`);
        } 
        else if (ext === 'pdf') {
            $container.html(`<embed src="{{ route('knowledge.drive.preview', '') }}/${file.id}#toolbar=0&navpanes=0" 
                                 type="application/pdf" width="100%" height="100%">`);
        }
        else if (['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'].includes(ext)) {
            $container.html(`
                <iframe src="https://view.officeapps.live.com/op/embed.aspx?src=${encodeURIComponent(window.location.origin + '/preview/' + file.id)}" 
                        width="100%" height="100%" frameborder="0"></iframe>
            `);
        }
        else {
            $('#unsupportedFile').show();
        }

        // Handle load/error events
        $container.find('img, embed, iframe').on('load', function() {
            $('#previewLoading').hide();
        }).on('error', function() {
            $('#previewLoading').hide();
            $('#unsupportedFile').show();
        });

        modal.show();
    }

    function goBack() {
        if (folderStack.length > 0) {
            const prevFolder = folderStack.pop();
            loadFolder(prevFolder);
        } else {
            loadFolder();
        }
    }

    function updateBreadcrumb(folderId) {
        // Implement your breadcrumb logic here
        // You might need an API endpoint to get folder hierarchy
        // For now, just show current folder
        if (!folderId) {
            $('#breadcrumb').html(`
                <li class="breadcrumb-item active">Root</li>
            `);
            return;
        }

        // Simple implementation - can be enhanced
        $('#breadcrumb').html(`
            <li class="breadcrumb-item"><a href="#" onclick="loadFolder()">Root</a></li>
            <li class="breadcrumb-item active">Current Folder</li>
        `);
    }
</script>
@endpush