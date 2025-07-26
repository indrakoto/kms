<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Article; // Sesuaikan dengan modelmu
use App\Models\Institusi;

class KnowledgeListx extends Component
{
    use WithPagination;

    public $viewMode = 'list';

    protected $queryString = ['viewMode'];

    public function updatingViewMode()
    {
        $this->resetPage();
    }

    public function render()
    {
        $knowledges = Article::with(['institusi', 'category', 'tags'])
            ->where('category_id', 2)
            ->where('is_published', 1)
            ->latest()
            ->paginate(9);


        return view('livewire.knowledge-list', [
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
