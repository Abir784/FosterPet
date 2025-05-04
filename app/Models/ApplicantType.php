<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantType extends Model
{
    use HasFactory;

    protected $table = 'applicant_types';

    protected $fillable = [
        'user_id',
        'pet_id',
        'foster_type',
        'status',
    ];
}

