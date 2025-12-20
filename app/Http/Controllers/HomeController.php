<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Semester;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Home - Projects List
     */
    public function index(Request $request)
    {
        $query = Project::with([
            'college:id,name',
            'semester:id,name,year,is_current'
        ]);

        // فلترة حسب الفصل
        if ($request->semester === 'current') {
            $currentSemester = Semester::where('is_current', true)->first();

            if ($currentSemester) {
                $query->where('semester_id', $currentSemester->id);
            }
        }

        if ($request->semester === 'previous') {
            $currentSemester = Semester::where('is_current', true)->first();

            if ($currentSemester) {
                $query->where('semester_id', '!=', $currentSemester->id);
            }
        }

        // فلترة حسب الكلية
        if ($request->filled('college_id')) {
            $query->where('college_id', $request->college_id);
        }

        $projects = $query->get()
            ->groupBy('college.name')
            ->map(function ($projects, $collegeName) {
                return [
                    'college' => $collegeName,
                    'projects' => $projects->map(function ($project) {
                        return [
                            'id' => $project->id,
                            'title' => $project->title,
                            'description' => $project->description,
                            'status' => $project->status,
                            'cover_image' => $project->cover_image,
                            'semester' => [
                                'name' => $project->semester->name,
                                'year' => $project->semester->year,
                                'is_current' => $project->semester->is_current,
                            ]
                        ];
                    })
                ];
            })
            ->values();

        return response()->json($projects);
    }
}
