<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;

class ImpersonateController extends Controller
{
    public function impersonate(User $user)
    {
        if (Auth::user()->isAdmin()) {  // Ensure only admins can impersonate
            $adminid = Auth::id();
            session(['impersonate' => Auth::id()]);  // Store the impersonated user ID
            Auth::login($user);  // Log in as the user
            session()->regenerate(); // Secure session
            \Log::info("Admin ID " . $adminid . " has Force Login User ID " . $user->id);
        }
        return redirect('/dashboard');  // Redirect to the user's dashboard
    }

    public function leaveImpersonation()
    {
        if (session()->has('impersonate')) {
            //echo "here";
            $adminId = session('impersonate');
            //echo $adminId;
            session()->forget('impersonate');
            Auth::loginUsingId($adminId);  // Log back into the admin account
            session()->regenerate(); // Secure session
            \Log::info("Admin ID " . $adminId . " has stopped FOrce Login.");
        }
        
        return redirect('/admin/dashboard');  // Redirect to admin panel
    }
}

