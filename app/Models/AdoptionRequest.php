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

    /**
     * Get all documents associated with this adoption request.
     */
    public function documents()
    {
        return $this->hasMany(Document::class, 'RequestID', 'adoptionID');
    }

    /**
     * Get the foster application type for this adoption request.
     */
    public function applicantType()
    {
        return $this->hasOne(ApplicantType::class, 'adoption_request_id', 'id');
    }
}
