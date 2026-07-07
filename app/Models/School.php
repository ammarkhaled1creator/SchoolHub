<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    protected $fillable=[
        "school_type_name",
        'name',
        "description",
        "phone",
        "website",
        "image",
    ];

    public function reviews()
   {
    return $this->hasMany(Review::class);
    }
}
