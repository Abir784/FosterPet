<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Donation;
use App\Models\User;

class DonationAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_id',
        'allocated_to',
        'allocation_type',
        'amount',
        'description',
        'status',
        'approved_by',
        'approved_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'approved_at' => 'datetime'
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
