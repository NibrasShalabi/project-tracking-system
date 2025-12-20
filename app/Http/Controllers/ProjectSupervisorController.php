<?php

namespace App\Http\Controllers;

use App\Models\ProjectSupervisor;
use Illuminate\Http\Request;

class ProjectSupervisorController extends Controller
{
    public function index()
    {
        $project_supervisors = ProjectSupervisor::all();
        return response()->json($project_supervisors);
    }
}
