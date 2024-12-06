<?php

namespace App\Controllers;

use App\Models\Product;

class PricingController extends Controller
{
    /**
     * PricingController constructor
     */
    public function __construct(
        private Product $product,
    ) {}

    /**
     * Show the pricing page
     *
     * @return mixed
     */
    public function __invoke()
    {
        $products = $this->product->wherePublished(true)->orderBy('order')->get();

        return view('vendor.pricing', compact('products'));
    }
}
