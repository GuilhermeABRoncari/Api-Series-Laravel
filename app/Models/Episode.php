<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;
    protected $casts = [
        'watched'=> 'boolean'
    ];
    protected $fillable = ['number'];

    public function season()
    {
        return $this->belongsTo(Season::class);
    }
}
