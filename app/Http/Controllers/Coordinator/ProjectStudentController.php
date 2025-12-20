<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectTeam;
use Illuminate\Http\Request;

class ProjectStudentController extends Controller
{
    /* عرض الطلاب المتقدمين على مشروع معين
     * GET /api/coordinator/projects/{project}/students
     */
    public function index(Request $request, $projectId)
    {
        // تأكد أن المشروع تابع للمنسق
        $project = Project::where('id', $projectId)
            ->where('coordinator_id', $request->user()->id)
            ->firstOrFail();

        $students = ProjectTeam::with('student')
            ->where('project_id', $projectId)
            ->get();

        return response()->json($students);
    }

    /* قبول طالب
     * PUT /api/coordinator/projects/{project}/students/{team}/accept
     */
    public function accept(Request $request, $projectId, $teamId)
    {
        $this->authorizeProject($request, $projectId);

        $team = ProjectTeam::where('id', $teamId)
            ->where('project_id', $projectId)
            ->firstOrFail();

        $team->status = 'accepted';
        $team->save();

        return response()->json([
            'message' => 'Student accepted successfully',
            'data' => $team
        ]);
    }

    /* رفض طالب
     * PUT /api/coordinator/projects/{project}/students/{team}/reject
     */
    public function reject(Request $request, $projectId, $teamId)
    {
        $this->authorizeProject($request, $projectId);

        $team = ProjectTeam::where('id', $teamId)
            ->where('project_id', $projectId)
            ->firstOrFail();

        $team->status = 'rejected';
        $team->save();

        return response()->json([
            'message' => 'Student rejected successfully',
            'data' => $team
        ]);
    }

    /* دالة داخلية للتأكد أن المشروع تابع للمنسق
     */
    private function authorizeProject(Request $request, $projectId)
    {
        Project::where('id', $projectId)
            ->where('coordinator_id', $request->user()->id)
            ->firstOrFail();
    }
}
