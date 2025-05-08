<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\DonationAllocation;
use App\Models\User;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_name',
        'donor_email',
        'amount',
        'currency',
        'payment_method',
        'transaction_id',
        'purpose',
        'remaining_amount',
        'status',
        'user_id'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
    ];

    public function allocations()
    {
        return $this->hasMany(DonationAllocation::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the total allocated amount for this donation.
     */
    public function getAllocatedAmountAttribute()
    {
        return $this->allocations->sum('amount');
    }
    
    /**
     * Get the percentage of the donation that has been allocated.
     */
    public function getAllocationPercentageAttribute()
    {
        if ($this->amount <= 0) {
            return 0;
        }
        
        return round(($this->allocated_amount / $this->amount) * 100);
    }
}
