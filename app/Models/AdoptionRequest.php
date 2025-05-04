<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdoptionRequest extends Model
{
     protected $fillable = ['adopterID', 'status'];

     /**
      * Relationship to the User (adopter)
      */
     public function adopter()
     {
         return $this->belongsTo(User::class, 'adopterID');
     }


     public function adoption()
     {
         return $this->belongsTo(Adoption::class, 'adoptionID');
     }
}
