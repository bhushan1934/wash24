<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function registerAndGenerateOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_no' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
    
        $mobile_no = $request->mobile_no;
    
        // Check if the user already exists
        $user = User::where('mobile_no', $mobile_no)->first();
    
        if (!$user) {
            // If user does not exist, register the user
            $user = new User(['mobile_no' => $mobile_no]);
            $user->save();
        }
    
        // Generate a 4-digit OTP
        $otp = rand(1000, 9999);
        $otp_expires_at = now()->addMinutes(10); // Set OTP expiration (e.g., 10 minutes)
    
        // Update user's OTP and its expiration time
        $user->otp = $otp;
        $user->otp_expires_at = $otp_expires_at;
        $user->save();
    
        // Code to send OTP via SMS goes here
    
        // Return response
        return response()->json([
            'message' => 'OTP sent successfully',
            'data' => [
                'user_id' => $user->id, // or any other user details you want to include
                'otp' => $otp
            ]
        ]);
    }
    



public function login(Request $request)
{
    // Validate the incoming request
    $validator = Validator::make($request->all(), [
        'mobile_no' => 'required',
        'otp' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }

    // Find the user by mobile number and validate the OTP
    $user = User::where('mobile_no', $request->mobile_no)
                ->where('otp', $request->otp)
                ->where('otp_expires_at', '>', now())
                ->first();

    // If the user is not found or OTP is invalid or expired
    if (!$user) {
        return response()->json(['message' => 'Invalid OTP or it has expired'], 401);
    }

    // OTP is verified, proceed to log the user in
    // Create a new token for the user
    $token = $user->createToken('authToken')->accessToken;

    // Optionally, you can reset or nullify the OTP to prevent reuse
    

    $user->remember_token = $token;
    $user->save();
    $userData = [
        'id' => $user->id,
        'mobile_no' => $user->mobile_no,
        // Include other user fields as needed
    ];
    // Return the token and success message
    return response()->json(['message' => 'Logged in successfully','user' => $userData, 'token' => $token]);
}
public function logout(Request $request)
{
    // Assuming you are using Passport for API authentication
    $token = $request->user()->token();
    $token->revoke(); // Revoke the token

    // Optionally, you can also remove the remember_token or any other fields if you store them
    $user = $request->user();
    $user->remember_token = null;
    $user->save();

    return response()->json(['message' => 'Successfully logged out']);
}


}
