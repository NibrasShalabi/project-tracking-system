<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectTeam;
use Illuminate\Http\Request;

class ProjectApplyController extends Controller
{
    /**
     * الطالب يتقدم على مشروع
     * POST /api/projects/{project}/apply
     */
    public function apply(Request $request, $projectId)
    {
        $studentId = $request->user()->id;

        // تأكد أن المشروع موجود
        $project = Project::findOrFail($projectId);

        // تأكد أن الطالب ما متقدّم قبل
        $alreadyApplied = ProjectTeam::where('project_id', $projectId)
            ->where('student_id', $studentId)
            ->exists();

        if ($alreadyApplied) {
            return response()->json([
                'message' => 'You have already applied to this project'
            ], 409);
        }

        // إنشاء الطلب بحالة pending
        $team = ProjectTeam::create([
            'project_id' => $projectId,
            'student_id' => $studentId,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Applied successfully',
            'data' => $team
        ], 201);
    }
}
