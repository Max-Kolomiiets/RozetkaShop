<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Category;

class CategoryItem extends Component
{
     public Category $category;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.category-item');
    }
}
