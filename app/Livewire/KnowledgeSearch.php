<?php
namespace App\Livewire;

use App\Models\Article;
use App\Models\Institusi;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Knowledge;

class KnowledgeSearch extends Component
{
    use WithPagination;

    public $search = '';
    protected $queryString = ['search' => ['except' => '']];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $institusis = Institusi::getMenuInstitusi();

        $results = Article::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%'.$this->search.'%')
                      ->orWhere('content', 'like', '%'.$this->search.'%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.knowledge-search', [
            'results' => $results,
            'institusis' => $institusis
        ]);
    }
}