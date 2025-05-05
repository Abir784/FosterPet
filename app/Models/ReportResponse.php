<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'admin_id',
        'response_content',
        'email_sent',
        'action_taken'
    ];

    public function report()
    {
        return $this->belongsTo(MessageReport::class, 'report_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
