<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adoption extends Model
{
    protected $guarded  = ['id'];

    public function pet()
    {
        return $this->belongsTo(pets::class,'pet_id');
    }

    // Relation to AdoptionRequest
    public function adoptionRequest()
    {
        return $this->hasOne(AdoptionRequest::class,'AdoptionID');
    }

}