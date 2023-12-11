<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Series extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'cover_path'];
    protected $appends = ['links'];

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    public function episodes()
    {
        return $this->hasManyThrough(Episode::class, Season::class);
    }

    public function links(): Attribute
    {
        return new Attribute(
                fn () => [
                [
                    'ref'=> 'self',
                    'url'=> "/api/series/{$this->id}"
                ],
                [
                    'ref'=> 'seasons',
                    'url'=> "/api/series/{$this->id}/seasons"
                ],
                [
                    'ref'=> 'episodes',
                    'url'=> "/api/series/{$this->id}/episodes"
                ]
            ]   
        );
    }
}
