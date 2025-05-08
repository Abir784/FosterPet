<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdoptionRequest extends Model
{
     use HasFactory;
     protected $guarded  = ['id'];
     protected $table = 'adoption_requests';


     protected $fillable = ['adoptionID', 'adopterID', 'status'];

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
     * Get all documents associated with this adoption request.
     */
    public function documents()
    {
        return $this->hasMany(Document::class, 'RequestID', 'id');
    }

    /**
     * Get the foster application type for this adoption request.
     */
    public function applicantType()
    {
        return $this->hasOne(ApplicantType::class, 'adoption_request_id', 'id');
    }

}
