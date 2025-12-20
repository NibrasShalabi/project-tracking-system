<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    // GET /api/semesters
    public function index()
    {
        return response()->json(Semester::all());
    }

    // POST /api/semesters
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'year' => 'required|integer',
        ]);

        $semester = Semester::create($request->only(
            'name',
            'start_date',
            'end_date',
            'year'
        ));

        return response()->json($semester, 201);
    }

    // PUT /api/semesters/{id}
    public function update(Request $request, $id)
    {
        $semester = Semester::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'year' => 'required|integer',
        ]);

        $semester->update($request->only(
            'name',
            'start_date',
            'end_date',
            'year'
        ));

        return response()->json($semester);
    }

    // DELETE /api/semesters/{id}
    public function destroy($id)
    {
        $semester = Semester::findOrFail($id);

        // حماية: لا نحذف فصل عليه مشاريع
        if ($semester->projects()->exists()) {
            return response()->json([
                'message' => 'Cannot delete semester with related projects'
            ], 409);
        }

        $semester->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
