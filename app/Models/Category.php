<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name_category', 'description_category', 'image_category'];

    public function facilities()
    {
        return $this->hasMany(Facility::class, 'category_id');
    }
}
