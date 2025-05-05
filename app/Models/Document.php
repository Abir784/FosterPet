<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'adopter_id',
        'document_name',
        'file_path',
        'document_type',
        'description'
    ];

    public function adopter()
    {
        return $this->belongsTo(User::class, 'adopter_id');
    }
}
