<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectWeek;
use App\Models\ProjectSupervisor;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'field' => 'required|string|max:255',
        'type'=> 'required|in:graduation,applicational,pre_graduation',
        'college_id' => 'required|exists:colleges,id',
        'semester_id' => 'required|exists:semesters,id',
        'coordinator_id' => 'required|exists:project_users,id',
        'cover_image' => 'nullable|image|max:2048',
        'supervisors' => 'required|array',
        'supervisors.*' => 'exists:project_users,id',
    ]);


    $coverPath = null;
    if ($request->hasFile('cover_image')) {
        $coverPath = $request->file('cover_image')->store('project/covers', 'public');
    }


    $project = Project::create([
        'title' => $validated['title'],
        'description' => $validated['description'] ,
        'field' => $validated['field'],
        'type'=> $validated['type'],
        'college_id' => $validated['college_id'],
        'semester_id' => $validated['semester_id'],
        'coordinator_id' => $validated['coordinator_id'],
        'cover_image' => $coverPath,
        'start_date' => now(),
        'status' => 'proposed',
    ]);


    foreach ($validated['supervisors'] as $supervisorId) {
        ProjectSupervisor::create([
            'project_id' => $project->id,
            'supervisor_id' => $supervisorId,
        ]);
    }


    for ($i = 1; $i <= 14; $i++) {
        ProjectWeek::create([
            'project_id' => $project->id,
            'week_number' => $i,
            'sprint_title' => 'Sprint ' . $i,
        ]);
    }

    return response()->json([
        'message' => 'Project created successfully',
        'project' => $project
    ], 201);
    }

    public function show($id)
{
    $project = Project::with([
        'college',
        'semester',
        'coordinator',
        'supervisors.supervisor', 
        'weeks',
        'teams.student', 
    ])->find($id);

    if (!$project) {
        return response()->json([
            'message' => 'Project not found'
        ], 404);
    }

    return response()->json([
        'project' => $project
    ]);
}

}
