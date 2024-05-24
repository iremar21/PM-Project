<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'creator_user_id',
        'assigned_user_id',
        'plan_id',
        'finishDate',
        'scheduledFinishDate',
        'completed',
        'slug'
    ];

    // Relación uno a muchos inversa
    public function creator() {
        return $this->belongsTo(User::class, 'creator_user_id');
    }

    // Relación uno a muchos inversa
    public function assignee() {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    // Relación uno a muchos inversa
    public function plan() {
        return $this->belongsTo(Plan::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
