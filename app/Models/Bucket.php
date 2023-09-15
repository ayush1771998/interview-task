<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bucket extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'capacity', 'filled_value'];

    public function balls()
    {
        return $this->belongsToMany(Ball::class)->withTimestamps();
    }
}
