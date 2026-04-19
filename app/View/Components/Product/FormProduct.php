<?php

namespace App\View\Components\Product;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormProduct extends Component
{
    /**
     * Create a new component instance.
     */
    public $product,$categories,$action;
    public function __construct($product =null)
    {
        $this->product = $product;
        $this->action = route('data-product.create');
        if(!empty($product)){
            $this->action = route('data-product.edit');
        }
        $this->categories = Category::orderBy('category_name','ASC')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.product.form-product');
    }
}
