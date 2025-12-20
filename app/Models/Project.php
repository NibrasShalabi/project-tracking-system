<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'field',
        'type',
        'status',
        'college_id',
        'semester_id',
        'coordinator_id',
        'start_date',
        'cover_image',
    ];

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function coordinator()
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    public function teams()
    {
        return $this->hasMany(ProjectTeam::class);
    }

    public function supervisors()
    {
        return $this->hasMany(ProjectSupervisor::class);
    }

    public function weeks()
    {
        return $this->hasMany(ProjectWeek::class);
    }

    public function tasks()
    {
        return $this->hasMany(ProjectTask::class);
    }
}
