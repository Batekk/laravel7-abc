<?php

namespace App;

use App\Models\mongo\MongoModel;

class Company extends MongoModel
{
    protected $fillable = ['user_id', 'name'];

    public function owner()
    {
        return $this->hasOne(User::class);
    }

    public function category()
    {
        return $this->hasOne(Category::class, '_id', 'category_id');
    }
}
