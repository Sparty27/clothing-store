<?php

namespace App\Models\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

interface Photoable 
{
    public function photos(): MorphMany;
    public function photo(): MorphOne;
}
