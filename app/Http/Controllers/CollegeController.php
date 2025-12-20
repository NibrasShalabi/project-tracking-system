<?php

namespace App\Http\Controllers;

use App\Models\College;
use Illuminate\Http\Request;

class CollegeController extends Controller
{
    public function index()
    {
        $colleges = College::all();
        return response()->json($colleges);
    }
    // test .......
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $college = College::create([
            'name' => $request->name
        ]);

        return response()->json($college, 201);
    }
    public function update(Request $request, $id)
{
    $college = College::findOrFail($id);

    $request->validate([
        'name' => 'required|string',
        'abbreviation' => 'nullable|string'
    ]);

    $college->update($request->only('name', 'abbreviation'));

    return response()->json($college);
}

public function destroy($id)
 {
    $college = College::findOrFail($id);

    // حماية: لا نحذف كلية عليها مستخدمين أو مشاريع
    if ($college->users()->exists() || $college->projects()->exists()) {
        return response()->json([
            'message' => 'Cannot delete college with related data'
        ], 409);
    }

    $college->delete();

    return response()->json(['message' => 'Deleted']);
 }
}
