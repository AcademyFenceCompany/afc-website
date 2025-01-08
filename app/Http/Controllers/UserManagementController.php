<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{   
    public function index()
    {
        $users = User::orderBy('created', 'desc')->get();
        return view('ams.user-management', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
{
    try {
        \Log::info('Request Data:', $request->all());

        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'level' => 'required|string', // Adjusted based on model constants
        ]);

        $user = User::find($id);

        if (!$user) {
            \Log::error('User not found with ID: ' . $id);
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        \Log::info('User Before Update:', $user->toArray());

        $user->update($validatedData);

        \Log::info('User After Update:', $user->toArray());

        return response()->json(['success' => true, 'message' => 'User updated successfully.']);
    } catch (\Exception $e) {
        \Log::error('Error updating user: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Server error.'], 500);
    }
}


}