<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class UserProfile extends Model
{
    // Set the table name if it's not the plural of the model name
    protected $table = 'users_profile';

    // Define fillable attributes if you plan to use mass assignment
    protected $fillable = [
        'user_id', 'name', 'address','gender'
        // Add other fillable fields here
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
