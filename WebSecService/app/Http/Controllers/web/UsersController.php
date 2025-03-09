<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function register()
    {
        return view('users.register');
    }

    public function doRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'security_question' => 'nullable|string',
            'security_answer' => 'nullable|string',
            'password' => 'required|confirmed|min:8',
        ]);

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->security_question = $request->security_question ?? null;
            $user->security_answer = $request->filled('security_answer') ? Hash::make($request->security_answer) : null;
            $user->password = Hash::make($request->password);
            $user->role = 'user';
            $user->save();

            return redirect('/login')->with('success', 'Registration successful! You can now log in.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error during saving: ' . $e->getMessage());
        }
    }

    public function login()
    {
        return view('users.login');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = User::where('email', $request->email)->first();

        // If user does not exist
        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        // Authenticate and log in user
        Auth::login($user);

        return redirect('/')->with('success', 'Login successful!');
    }


    public function doLogout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'You have been logged out.');
    }

    public function profile()
    {
        return view('users.profile', ['user' => Auth::user()]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|min:8',
            'new_password' => 'required|confirmed|min:8',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password updated successfully.');
    }

    public function forgotPassword()
    {
        return view('users.forgot_password');
    }

    public function verifySecurityQuestion(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'security_answer' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->security_answer, $user->security_answer)) {
            return back()->withErrors(['security_answer' => 'Incorrect answer.']);
        }

        return view('users.reset_password', compact('user'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::find($request->user_id);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/login')->with('success', 'Password reset successfully. You can now log in.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function save(Request $request, User $user = null)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($user ? $user->id : 'NULL'),
            'role' => 'required|string|in:admin,user',
            'security_question' => 'nullable|string',
            'security_answer' => 'nullable|string',
            'password' => $user ? 'nullable|min:8' : 'required|min:8|confirmed',
        ]);

        $user = $user ?? new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->security_question = $request->security_question ?? null;

        if ($request->filled('security_answer')) {
            $user->security_answer = Hash::make($request->security_answer);
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        } elseif (!$user->exists) {
            return back()->with('error', 'Password is required when adding a new user.');
        }

        $user->save();

        return redirect()->route('users_list')->with('success', 'User saved successfully.');
    }

    public function delete(User $user)
    {
        $user->delete();
        return redirect()->route('users_list')->with('success', 'User deleted successfully.');
    }
}
