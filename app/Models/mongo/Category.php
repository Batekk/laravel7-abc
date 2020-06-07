<?php

namespace App;

use App\Models\mongo\MongoModel;

class Category extends MongoModel
{
    protected $fillable = ['company_id', 'name'];
}
