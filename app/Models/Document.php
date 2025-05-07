<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\AdoptionRequest;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'RequestID',
        'file_path',
        'user_id'
    ];

    /**
     * Get the user that owns the document.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the adoption request associated with the document.
     */
    public function adoptionRequest()
    {
        return $this->belongsTo(AdoptionRequest::class, 'RequestID', 'adoptionID');
    }
}
