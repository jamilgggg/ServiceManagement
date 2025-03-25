<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class Sidebar extends Component
{
    public string $view;

    public function __construct()
    {
        $this->view = Auth::check() && Auth::user()->idacctype == 1
            ? 'layouts.sideNavAdmin'
            : 'layouts.sideNavHd';
    }

    public function render()
    {
        return view($this->view);
    }
}
