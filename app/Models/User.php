<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;

    protected $table = 'project_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'college_id',
        'student_number',
        'profile_image',
        'is_active',
    ];

    protected $hidden = [
        'password',
    ];

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function projectsAsCoordinator()
    {
        return $this->hasMany(Project::class, 'coordinator_id');
    }

    public function projectTeams()
    {
        return $this->hasMany(ProjectTeam::class, 'student_id');
    }

    public function tasks()
    {
        return $this->hasMany(ProjectTask::class, 'student_id');
    }

    public function projectSupervisions()
    {
        return $this->hasMany(ProjectSupervisor::class, 'supervisor_id');
    }
}
