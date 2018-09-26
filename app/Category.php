<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'body'
    ];

    public function worksDesign(){
        return $this->hasMany(WorkDesign::class);
    }
}
