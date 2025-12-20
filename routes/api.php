<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
// use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\ProjectSupervisorController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Coordinator\ProjectController;
use App\Http\Controllers\Coordinator\ProjectTeamController;
use App\Http\Controllers\Coordinator\ProjectStudentController;
use App\Http\Controllers\Student\ProjectApplyController;
use App\Http\Controllers\HomeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);


// Route::middleware('auth:sanctum')->group(function(){
//     Route::post('projects',[ProjectController::class,'store']);
// });
// Route::middleware('auth:sanctum')->get('projects/{id}', [ProjectController::class, 'show']);

Route::middleware(['auth:sanctum' , 'role:coordinator'])->get('test-role',function(){
    return response()->json(['message' => 'ok']);
});

Route::get('/colleges', [CollegeController::class, 'index']);
// test
Route::post('/colleges', [CollegeController::class, 'store']);
Route::put('/colleges/{id}', [CollegeController::class, 'update']);
Route::delete('/colleges/{id}', [CollegeController::class, 'destroy']);
// .......
Route::get('/semesters', [SemesterController::class, 'index']);
Route::post('/semesters', [SemesterController::class, 'store']);
Route::put('/semesters/{id}', [SemesterController::class, 'update']);
Route::delete('/semesters/{id}', [SemesterController::class, 'destroy']);
//.............
Route::get('/supervisor', [ProjectSupervisorController::class, 'index']);

// Admin .........................
Route::middleware(['auth:sanctum', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

        // Users management
        Route::get('/users', [UserManagementController::class, 'index']);
        Route::put('/users/{id}/role', [UserManagementController::class, 'changeRole']);
        Route::put('/users/{id}/toggle-status', [UserManagementController::class, 'toggleStatus']);
        // Create coordinator
        Route::post('/coordinators', [UserManagementController::class, 'createCoordinator']);
    });
// ......................................
// Coordinator
Route::middleware(['auth:sanctum', 'role:coordinator'])
    ->prefix('coordinator')
    ->group(function () {

        Route::get('/projects', [ProjectController::class, 'index']);
        Route::post('/projects', [ProjectController::class, 'store']);
        Route::get('/projects/{id}', [ProjectController::class, 'show']);
        Route::put('/projects/{id}', [ProjectController::class, 'update']);
        Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);
        Route::get('/projects/{id}/students',[ProjectTeamController::class, 'index']);
        Route::put('/team/{id}/approve',[ProjectTeamController::class, 'approve']);
        Route::put('/team/{id}/reject',[ProjectTeamController::class, 'reject']);
    });
    //.....................




Route::middleware(['auth:sanctum', 'role:student'])
    ->post('/projects/{id}/apply', [ProjectTeamController::class, 'apply']);
Route::middleware('auth:sanctum')->get('/whoami', function (Request $request) {
    return response()->json([
        'id' => $request->user()->id,
        'email' => $request->user()->email,
        'role' => $request->user()->role,
    ]);
});
Route::middleware('auth:sanctum')->get(
    '/projects/{id}/overview',
    [ProjectController::class, 'overview']
);
//  coordinator page ..................
Route::middleware(['auth:sanctum', 'role:coordinator'])
    ->prefix('coordinator')
    ->group(function () {

        Route::get(
            '/projects/{project}/students',
            [ProjectStudentController::class, 'index']
        );

        Route::put(
            '/projects/{project}/students/{team}/accept',
            [ProjectStudentController::class, 'accept']
        );

        Route::put(
            '/projects/{project}/students/{team}/reject',
            [ProjectStudentController::class, 'reject']
        );
    });
//.......................
// apply stu .................

Route::middleware(['auth:sanctum', 'role:student'])->group(function () {
    Route::post(
        '/projects/{project}/apply',
        [ProjectApplyController::class, 'apply']
    );
});
//......................
// home page ..............
Route::middleware('auth:sanctum')->get(
    '/home/projects',
    [HomeController::class, 'index']
);
//........................
