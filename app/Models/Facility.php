<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = ['category_id', 'name_facility', 'location', 'condition'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'facility_id');
    }
}