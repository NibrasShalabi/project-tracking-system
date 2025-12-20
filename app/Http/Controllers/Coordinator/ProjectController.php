<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /* عرض مشاريع المنسق فقط
     * GET /api/coordinator/projects
     */
    public function index(Request $request)
    {
        return Project::with(['college', 'semester'])
            ->where('coordinator_id', $request->user()->id)
            ->get();
    }

    /* إضافة مشروع جديد (Project Form)
     * POST /api/coordinator/projects
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'field' => 'required|string',
            'type' => 'required|in:graduation,applicational,pre_graduation',
            'college_id' => 'required|exists:colleges,id',
            'semester_id' => 'required|exists:semesters,id',
            'start_date' => 'required|date',
        ]);

        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'field' => $request->field,
            'type' => $request->type,
            'status' => 'proposed',
            'college_id' => $request->college_id,
            'semester_id' => $request->semester_id,
            'coordinator_id' => $request->user()->id,
            'start_date' => $request->start_date,
        ]);

        return response()->json($project, 201);
    }

    /* عرض مشروع واحد للمنسق
     * GET /api/coordinator/projects/{id}
     */
    public function show(Request $request, $id)
    {
        return Project::with(['college', 'semester'])
            ->where('coordinator_id', $request->user()->id)
            ->findOrFail($id);
    }

    /* تعديل مشروع
     * PUT /api/coordinator/projects/{id}
     */
    public function update(Request $request, $id)
    {
        $project = Project::where('coordinator_id', $request->user()->id)
            ->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:proposed,in_progress,completed',
            'college_id' => 'required|exists:colleges,id',
            'semester_id' => 'required|exists:semesters,id',
        ]);

        $project->update($request->only([
            'title',
            'description',
            'status',
            'college_id',
            'semester_id',
        ]));

        return $project;
    }

    /* حذف مشروع
     * DELETE /api/coordinator/projects/{id}
     */
    public function destroy(Request $request, $id)
    {
        $project = Project::where('coordinator_id', $request->user()->id)
            ->findOrFail($id);

        $project->delete();

        return response()->json(['message' => 'Project deleted']);
    }

    public function overview($id)
   {
       $project = Project::with([
           'college',
           'semester',
           'coordinator',
           'supervisors.supervisor',
           'teams.student'
        ])->findOrFail($id);

    return response()->json($project);
    }
}
