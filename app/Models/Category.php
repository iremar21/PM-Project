<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Relación uno a muchos
    public function plan() {
        return $this->hasMany(Plan::class);
    }
}
