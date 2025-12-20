<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    // جلب كل المستخدمين
 public function index()
    {
        return User::with('college')->get();
    }

    public function changeRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,coordinator,supervisor,student'
        ]);

        $user = User::findOrFail($id);

        // منع تغيير دور الأدمن
        if ($user->role === 'admin') {
            return response()->json([
                'message' => 'Cannot change admin role'
            ], 403);
        }

        $user->role = $request->role;
        $user->save();

        return $user;
    }

  // المسؤولة عن تفعيل و الغاء الحساب
    public function toggleStatus($id)

    {
    $user = User::findOrFail($id);

    if ($user->role === 'admin') {
        return response()->json([
            'message' => 'Cannot disable admin'
        ], 403);
    }

    $user->is_active = !$user->is_active;
    $user->save();

    return $user;
    }
    // انشاء user  من ال admin
    public function createCoordinator(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:project_users,email',
        'password' => 'required|string|min:8',
        'college_id' => 'required|exists:colleges,id',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'college_id' => $request->college_id,
        'role' => 'coordinator',
        'is_active' => true,
    ]);

    return response()->json($user, 201);
}

}
