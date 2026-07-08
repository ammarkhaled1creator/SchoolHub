<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;






class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_type_id', 'name', 'description', 'phone', 'website', 'image',
    ];
    public function schoolType()
    {
        return $this->belongsTo(SchoolType::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function tuition_fees()
    {
        return $this->hasMany(TuitionFees::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function schoolType(){
        return $this->belongsTo(SchoolType::class);
    }
}
