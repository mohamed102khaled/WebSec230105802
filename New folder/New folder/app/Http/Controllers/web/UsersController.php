<?php
 namespace App\Http\Controllers\Web;

 use Illuminate\Http\Request;
 use App\Models\User;
 use App\Http\Controllers\Controller;
 use Illuminate\Support\Facades\Auth;
 use Illuminate\Support\Facades\Hash;
 
 class UsersController extends Controller
 {
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

     /** 📝 Show the registration page */
     public function register()
     {
         return view('users.register');
     }
 
     /** 📝 Handle user registration */
     public function doRegister(Request $request)
     {
         // Validate user input
         $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|email|unique:users,email',
             'security_question' => 'nullable|string',
             'security_answer' => 'nullable|string',
             'password' => 'required|confirmed|min:8',
         ]);
 
         // Create user with hashed password
         User::create([
             'name' => $request->name,
             'email' => $request->email,
             'security_question' => $request->security_question ?? null,
             'security_answer' => $request->security_answer ? Hash::make($request->security_answer) : null,
             'password' => Hash::make($request->password),
         ]);
 
         return redirect('/login')->with('success', 'Registration successful! You can now log in.');
     }
 
     /** 📝 Show the login page */
     public function login()
     {
         return view('users.login');
     }
 
     /** 📝 Handle user login */
     public function doLogin(Request $request)
     {
         // Validate input
         $request->validate([
             'email' => 'required|email',
             'password' => 'required|min:8',
         ]);
 
         // Fetch user from database
         $user = User::where('email', $request->email)->first();
 
         // Check if user exists
         if (!$user) {
             return back()->with('error', 'User not found.');
         }
 
         // Check if password is correct
         if (!Hash::check($request->password, $user->password)) {
             return back()->with('error', 'Incorrect password.');
         }
 
         // Authenticate user
         Auth::login($user);
 
         return redirect('/')->with('success', 'Login successful!');
     }
 
     /** 📝 Handle user logout */
     public function doLogout()
     {
         Auth::logout();
         return redirect('/login')->with('success', 'You have been logged out.');
     }
 
     /** 📝 Show profile page */
     public function profile()
     {
         return view('users.profile', ['user' => Auth::user()]);
     }
 
     /** 📝 Handle password update */
     public function updatePassword(Request $request)
     {
         // Validate input
         $request->validate([
             'current_password' => 'required|min:8',
             'new_password' => 'required|confirmed|min:8',
         ]);
 
         $user = Auth::user();
 
         // Check if current password is correct
         if (!Hash::check($request->current_password, $user->password)) {
             return back()->with('error', 'Current password is incorrect.');
         }
 
         // Update password
         $user->password = Hash::make($request->new_password);
         $user->save();
 
         return back()->with('success', 'Password updated successfully.');
     }
 
     /** 📝 Show forgot password page */
     public function forgotPassword()
     {
         return view('users.forgot_password');
     }
 
     /** 📝 Verify security question and redirect to reset password */
     public function verifySecurityQuestion(Request $request)
     {
         // Validate input
         $request->validate([
             'email' => 'required|email|exists:users,email',
             'security_answer' => 'required|string',
         ]);
 
         $user = User::where('email', $request->email)->first();
 
         // Check if security answer is correct
         if (!$user || !Hash::check($request->security_answer, $user->security_answer)) {
             return back()->withErrors(['security_answer' => 'Incorrect answer.']);
         }
 
         return view('users.reset_password', compact('user'));
     }
 
     /** 📝 Reset password */
     public function resetPassword(Request $request)
     {
         // Validate input
         $request->validate([
             'user_id' => 'required|exists:users,id',
             'password' => 'required|confirmed|min:8',
         ]);
 
         $user = User::find($request->user_id);
         $user->password = Hash::make($request->password);
         $user->save();
 
         return redirect('/login')->with('success', 'Password reset successfully. Please login.');
     }
 }
 