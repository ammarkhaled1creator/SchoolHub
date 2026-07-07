<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuitionFees extends Model
{
    use HasFactory;

    protected $fillable=[
        "school_id",
        "grade",
        "price",
        "academic_year"
    ];

    public function school(){
        return $this->belongsTo(School::class);
    }
}
