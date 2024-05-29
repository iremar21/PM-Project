<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'status',
        'completed',
        'creator_user_id',
        'manager_user_id',
        'creationDate',
        'finishDate',
        'scheduledFinishDate',
        'slug'
    ];

    // Relación uno a muchos inversa
    public function creator() {
        return $this->belongsTo(User::class, 'creator_user_id');
    }

    // Relación uno a muchos inversa
    public function manager() {
        return $this->belongsTo(User::class, 'manager_user_id');
    }

    // Relación uno a muchos inversa
    public function category() {
        return $this->belongsTo(Category::class);
    }

    // Relación uno a muchos
    public function tasks() {
        return $this->hasMany(Task::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Método boot para generar el slug automáticamente
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($plan) {
            $plan->slug = self::createUniqueSlug($plan->title);
        });

        static::updating(function ($plan) {
            if ($plan->isDirty('title')) {
                $plan->slug = self::createUniqueSlug($plan->title);
            }
        });
    }

    private static function createUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $count = Plan::where('slug', 'LIKE', "{$slug}%")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }
}
