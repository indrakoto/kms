<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Article; // Sesuaikan dengan modelmu
use App\Models\Institusi;

class KnowledgeInstitusi extends Component
{
    use WithPagination;


    public $viewMode = 'list';
    public $slug;  // Add the slug property

    protected $queryString = ['viewMode'];

    public function mount($slug) // Add the slug to the mount method
    {
        $this->slug = $slug; // Capture the slug from URL
    }

    public function updatingViewMode()
    {
        $this->resetPage();
    }

    public function render()
    {
        // 1. Cari institusi/sub-institusi berdasarkan slug (unik)
        $institusi = Institusi::where('slug', $this->slug)
            ->with(['parentRelation', 'children']) // Eager load relasi
            ->firstOrFail();
    
        
        // 2. Dapatkan artikel terkait institusi ini
        $knowledges = $institusi->articles()
            ->with(['category', 'tags'])
            ->where([
                    ['category_id', '=', 2],
                    ['is_published', '=', 1]
                ])
            ->paginate(9);

        $knowledgesx = Article::with(['institusi', 'category', 'tags'])
            ->where('category_id', 2)
            ->where('is_published', 1)
            ->latest()
            ->paginate(9);


        return view('livewire.knowledge-institusi', [
            'knowledges' => $knowledges,
            'viewMode' => $this->viewMode,
        ]);
    }

    /*public function paginationView()
    {
        return 'vendor.pagination.bootstrap-5';
    }*/
        
    public function paginationView()
    {
        return 'livewire.bootstrap5-pagination';
    }


}
