<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectTeam;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectTeamController extends Controller
{
    /* عرض طلبات الطلاب (pending فقط)
     * GET /api/coordinator/projects/{projectId}/students
     */
    public function index(Request $request, $projectId)
    {
        // تأكد أن المشروع تابع للمنسق
        Project::where('coordinator_id', $request->user()->id)
            ->findOrFail($projectId);

        return ProjectTeam::with('student')
            ->where('project_id', $projectId)
            ->where('status', 'pending')
            ->get();
    }

    /* طالب يتقدم للتسجيل (pending)
     * POST /api/projects/{projectId}/apply
     */
    public function apply(Request $request, $projectId)
    {
        $student = $request->user();

        if ($student->role !== 'student') {
            return response()->json(['message' => 'Only students can apply'], 403);
        }

        $exists = ProjectTeam::where([
            'project_id' => $projectId,
            'student_id' => $student->id,
        ])->exists();

        if ($exists) {
            return response()->json(['message' => 'Already applied'], 409);
        }

        $team = ProjectTeam::create([
            'project_id' => $projectId,
            'student_id' => $student->id,
            'status' => 'pending',
        ]);

        return response()->json($team, 201);
    }

    /* قبول طالب
     * PUT /api/coordinator/team/{id}/approve
     */
    public function approve(Request $request, $id)
    {
        $team = ProjectTeam::findOrFail($id);

        // تأكد أن المشروع تابع للمنسق
        Project::where('id', $team->project_id)
            ->where('coordinator_id', $request->user()->id)
            ->firstOrFail();

        $team->status = 'approved';
        $team->save();

        return response()->json(['message' => 'Student approved']);
    }

    /* رفض طالب
     * PUT /api/coordinator/team/{id}/reject
     */
    public function reject(Request $request, $id)
    {
        $team = ProjectTeam::findOrFail($id);

        Project::where('id', $team->project_id)
            ->where('coordinator_id', $request->user()->id)
            ->firstOrFail();

        $team->status = 'rejected';
        $team->save();

        return response()->json(['message' => 'Student rejected']);
    }
}
