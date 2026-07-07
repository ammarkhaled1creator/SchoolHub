<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable=[
    "school_id",
    "city",
    "address",
    "google_maps_link"
    ];

    public function school(){
        return $this->belongsTo(School::class);
    }
}
