<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdoptionRequest extends Model
{
     use HasFactory;
     
     protected $fillable = ['adopterID', 'status'];

     /**
      * Relationship to the User (adopter)
      */
     public function adopter()
     {
         return $this->belongsTo(User::class, 'adopterID');
     }

     /**
      * Relationship to the Adoption
      */
     public function adoption()
     {
         return $this->belongsTo(Adoption::class, 'adoptionID');
     }
     
     /**
      * Get the responses for the adoption request.
      */
     public function responses()
     {
         return $this->hasMany(AdoptionResponse::class, 'adoption_request_id');
     }
     
     /**
      * Get the count of support responses.
      */
     public function getSupportCountAttribute()
     {
         return $this->responses()->where('response', 'support')->count();
     }
     
     /**
      * Get the count of oppose responses.
      */
     public function getOpposeCountAttribute()
     {
         return $this->responses()->where('response', 'oppose')->count();
     }
     
     /**
      * Get the count of neutral responses.
      */
     public function getNeutralCountAttribute()
     {
         return $this->responses()->where('response', 'neutral')->count();
     }
}