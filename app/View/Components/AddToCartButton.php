<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AddToCartButton extends Component
{
    /**
     * The product data.
     *
     * @var object|array|null
     */
    public $product;

    /**
     * Create a new component instance.
     *
     * @param object|array|null $product
     * @return void
     */
    public function __construct($product = null)
    {
        $this->product = $product;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.add-to-cart-button');
    }
}
