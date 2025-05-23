<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;  // Changed from UserType to Role
use App\Models\UserStatus;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getUsers()
    {
        $users = User::with(['role', 'status'])->get();  // Changed relationship names
        return response()->json(['users' => $users]);
    }

    public function addUser(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'user_type_id' => ['required', 'exists:roles,id'],  // Consistent naming
            'user_status_id' => ['required', 'exists:user_statuses,id'],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type_id' => $request->user_type_id,  // Fixed field name
            'user_status_id' => $request->user_status_id,
        ]);

        return response()->json([
            'message' => 'User successfully created!',
            'user' => $user->load(['role', 'status'])
        ], 201);
    }

    public function editUser(Request $request, $id)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $id],
            'password' => ['nullable', 'string', 'min:8'],  // Added password field
            'user_type_id' => ['required', 'exists:roles,id'],
            'user_status_id' => ['required', 'exists:user_statuses,id'],
        ]);

        $user = User::findOrFail($id);

        $updateData = [
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'user_type_id' => $request->user_type_id,  // Fixed field name
            'user_status_id' => $request->user_status_id,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return response()->json([
            'message' => 'User successfully updated!',
            'user' => $user->fresh(['role', 'status'])
        ]);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        return response()->json(['message' => 'User successfully deleted!']);
    }
}