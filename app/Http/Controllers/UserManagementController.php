<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{   
    public function index()
    {
        if (auth()->user()->level !== 'God') {
            abort(403);
        }
        $users = User::orderBy('created', 'desc')->get();
        return view('ams.user-management', compact('users'));
    }

public function store(Request $request)
{
    try {
        $validatedData = $request->validate([
            'username' => 'required|string|unique:ams-users|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'level' => 'required|in:Staff,Admin,God'
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);
        $validatedData['enabled'] = true;
        $validatedData['created'] = now();

        $user = User::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully'
        ]);

    } catch (\Exception $e) {
        \Log::error('Error creating user: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

    public function update(Request $request, $id)
{
    try {
        // Debug: Log the raw request content
        \Log::info('Raw request content:', [
            'content' => $request->getContent(),
            'headers' => $request->headers->all()
        ]);

        $user = User::findOrFail($id);
        
        $rules = [
            'username' => 'required|string|max:255|unique:ams-users,username,' . $id,
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'level' => 'required|in:Staff,Admin,God'
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:6';
        }

        $validatedData = $request->validate($rules);

        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($request->password);
        }

        $user->update($validatedData);
        
        return response()->json(['success' => true]);
        
    } catch (\Exception $e) {
        \Log::error('Update error:', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

public function destroy($id)
{
    try {
        $user = User::findOrFail($id);
        
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete your own account'
            ], 403);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);

    } catch (\Exception $e) {
        \Log::error('Error deleting user: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}


public function toggleStatus($id)
{
    try {
        $user = User::findOrFail($id);
        
        // Prevent self-disable
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot disable your own account'
            ], 403);
        }

        $user->enabled = !$user->enabled;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User status updated successfully'
        ]);

    } catch (\Exception $e) {
        \Log::error('Error toggling user status: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
}