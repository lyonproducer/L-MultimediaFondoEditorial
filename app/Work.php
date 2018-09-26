<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $fillable=[
        'work_design_id', 'title', 'description','type', 'file'
    ];

    public function work(){
        return $this->belongsTo(WorkDesign::class);
    }

}
