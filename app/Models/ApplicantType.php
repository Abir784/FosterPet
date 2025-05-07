<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantType extends Model
{
    use HasFactory;

    protected $table = 'applicant_types';

    /**
     * Get the adoption request that this applicant type belongs to.
     */
    public function adoptionRequest()
    {
        return $this->belongsTo(AdoptionRequest::class, 'adoption_request_id');
    }

    protected $fillable = [
        'user_id',
        'adoption_request_id',
        'foster_type',
        'status',
        'duration',
        'temporary_address',
        'employment_status',
        'housing_status',
    ];
    
    protected $casts = [
        'duration' => 'integer',
    ];
}
