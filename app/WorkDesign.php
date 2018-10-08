<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkDesign extends Model
{
    
    protected $fillable=[
        'user_id', 
        'category_id', 
        'title', 
        'excerpt',
        'description',
        'status',
        'publishedDate',
        'dependency', 
        'file',
        'uploadBy'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function workDesigns(){
        return $this->hasMany(Work::class);
    }
}
