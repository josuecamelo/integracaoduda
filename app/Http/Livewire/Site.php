<?php

namespace App\Http\Livewire;

use App\Models\Area;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Site extends Component
{
    use WithPagination, LivewireAlert;

    private $sites = [];

    public function __construct($id = null, \App\Models\Site $sites)
    {
        parent::__construct($id);
        $this->sites = $sites;
    }

    public function render()
    {
        $this->sites = $this->sites
            ->paginate(5);

        return view('livewire.sites.index', [
            'sites' => $this->sites
        ]);
    }
}
