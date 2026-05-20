<?php

namespace App\View\Composers;

use App\Support\Cart;
use Illuminate\View\View;

class GlobalComposer
{
    public function compose(View $view): void
    {
        $view->with('cartCount', Cart::totalQty());
    }
}
