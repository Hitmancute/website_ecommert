<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public $links;
    public function __construct()
    {
        $this->links = [
            [
                'type'  => 'section',
                'title'  => 'Home',
                'icon'  => 'ti-dots',
            ],
            [
                'type'  => 'menu',
                'name'  => 'Dashboard',
                'route'  => 'home',
                'active'  => 'home',
                'icon'  => 'ti-brand-windows',
            ],
            [
                'type'  => 'menu',
                'name'  => 'Categories',
                'route'  => 'data-category.index',
                'active'  => 'data-category.*',
                'icon'  => 'ti-category',
            ],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar');
    }
}
