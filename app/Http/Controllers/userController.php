<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Validator;

use App\Models\User;  // Import the User model

use Illuminate\Http\Request;

class userController extends Controller
{
    public function getuser(Request $request) {
        // Gets the authenticated user along with their user profile
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Load the user's profile. Assuming the relation is defined in the User model
        $user->load('userProfile');

        return response()->json($user);
    }
  
    public function createUserProfile(Request $request) {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string',
            // other validation rules
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
    
       
    
        // Get the authenticated user
       // Temporary manual authentication for debugging
 // Use a known user ID
$user = auth()->user();

    
        // Create and save the new user profile
        $userProfile = $user->userProfile()->create([
            'name' => $request->name,
            'gender' => $request->gender,
            'address' => $request->address,
            // other fields
        ]);
    
        if ($userProfile) {
            return response()->json(['message' => 'User profile created successfully', 'profile' => $userProfile], 201);
        } else {
            return response()->json(['message' => 'Failed to create user profile'], 500);
        }
    }
    
    
}
