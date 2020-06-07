<?php

namespace App;

use App\Models\mongo\MongoModel;

class Service extends MongoModel
{
    protected $fillable = ['category_id', 'name'];
}
