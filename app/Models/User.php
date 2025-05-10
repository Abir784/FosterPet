<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



        // Accepted friends (includes both sent and received requests)
    public function friends()
    {
        // Get friend IDs for both sides of the relationship
        $userId = $this->id;
        
        // Get user IDs of friends
        $sentFriendIds = \App\Models\FriendRequest::where('sender_id', $userId)
            ->where('status', 'accepted')
            ->pluck('receiver_id');
            
        $receivedFriendIds = \App\Models\FriendRequest::where('receiver_id', $userId)
            ->where('status', 'accepted')
            ->pluck('sender_id');
            
        // Combine IDs and get users
        $friendIds = $sentFriendIds->merge($receivedFriendIds);
        
        // Query users with these IDs and add the friendship timestamps as a subquery
        return User::whereIn('id', $friendIds);
    }
        public function sentRequests()
        {
            return $this->hasMany(FriendRequest::class, 'sender_id');
        }

        public function receivedRequests()
        {
            return $this->hasMany(FriendRequest::class, 'receiver_id');
        }

    /**
     * Get all documents uploaded by the user.
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
    
    /**
     * Get all donations made by the user.
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
