<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'reporter_id',
        'reported_message_id',
        'reason',
        'description',
        'status'
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function reportedMessage()
    {
        return $this->belongsTo(Message::class, 'reported_message_id');
    }

    public function response()
    {
        return $this->hasOne(ReportResponse::class, 'report_id');
    }
}
