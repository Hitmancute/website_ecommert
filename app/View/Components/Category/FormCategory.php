<?php

namespace App\View\Components\Category;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormCategory extends Component
{
    /**
     * Create a new component instance.
     */
    public $category, $category_name, $image, $action;
    public function __construct($category = null)
    {
        $this->action = route('data-category.store');
        $this->category = $category;
        if($category){
            $this->action = route('data-category.store',$category->id);
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.category.form-category');
    }
}
