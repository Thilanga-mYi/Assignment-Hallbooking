<?php

namespace App\Models;

class Colors
{
    protected $colorsStatus = ['success', 'warning', 'danger', 'secondary'];

    public function getColor($value)
    {
        return $this->colorsStatus[$value-1];
    }
}
