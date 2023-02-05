<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;
use Closure;

class SquarePayment extends Field
{
    protected string $view = 'forms.components.square-payment';

    public float | Closure | null $price;

    public function setCurrentPrice(float | Closure | null $price): static
    {
        $this->price = $price;
        return $this;
    }

    public function getCurrentPrice(): float
    {
        return $this->evaluate($this->price);
    }
}
