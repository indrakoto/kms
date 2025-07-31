@extends('layouts.app')

@section('title', 'KMS - Knowledge')

@section('content')
    <!-- Knowledges Section -->
    <section id="knowledges" class="knowledges section">
        @include('section.page-title')
        <div class="container">
            <div class="row">
                <!-- Sidebar untuk memilih Institusi -->
                <div class="col-lg-3">
                    <div class="mb-4">
                        <!-- Include Search Form -->
                        @include('section.search')
                    </div>
                    <div class="menu-myside">
                        @foreach ($institusis as $item)
                            @include('section.sidebar-knowledge', ['item' => $item])
                        @endforeach
                    </div>
                </div>

                <!-- Konten untuk Artikel Knowledge (Livewire) -->
                <div class="col-lg-9">
                    @livewire('knowledge-institusi', ['slug' => $slug])
                </div>
            </div>
        </div>
    </section>
    <!-- /Knowledges Section -->
@endsection

@push('scripts')
<script>
function toggleSubMenu(id, parent) {
    var submenu = document.getElementById(id);
    if (submenu) {
        submenu.classList.toggle('show');
        var icon = parent.querySelector('.menu-arrow');
        if (icon) {
            icon.classList.toggle('rotate-180');
        }
    }
}
function attachDropdownEvents() {
    document.querySelectorAll('.menu-parent').forEach(function(parent) {
        parent.onclick = function() {
            var id = this.getAttribute('onclick').match(/'([^']+)'/)[1];
            toggleSubMenu(id, this);
        }
    });
}
document.addEventListener('DOMContentLoaded', function () {
    attachDropdownEvents();
});
document.addEventListener('livewire:navigated', function () {
    attachDropdownEvents();
});
document.addEventListener('livewire:update', function () {
    attachDropdownEvents();
});
</script>
@endpush
