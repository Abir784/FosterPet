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
        'remaining_amount',
        'currency',
        'payment_method',
        'transaction_id',
        'purpose',
        'status',
        'user_id',
        'pet_id',
        'donation_type', 
        'start_date',
        'end_date',
        'paypal_payment_id',
        'paypal_payer_id',
        'paypal_token'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
    ];

    public function allocations()
    {
        return $this->hasMany(DonationAllocation::class);
    }

    public function getRemainingAmountAttribute()
    {
        $allocatedAmount = $this->allocations()->sum('amount');
        return $this->amount - $allocatedAmount;
    }

    public function allocated_amount()
    {
        return $this->allocations()->sum('amount');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pet()
    {
        return $this->belongsTo(pets::class);
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
