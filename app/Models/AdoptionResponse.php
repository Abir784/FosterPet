<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'adoption_request_id',
        'user_id',
        'comment',
        'response',
    ];

    /**
     * Get the adoption request that owns the response.
     */
    public function adoptionRequest()
    {
        return $this->belongsTo(AdoptionRequest::class, 'adoption_request_id');
    }

    /**
     * Get the user who made the response.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
