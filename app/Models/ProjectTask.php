<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'week_id',
        'student_id',
        'title',
        'description',
        'status',
        'start_date',
        'duer_date',
        'note_supervisor',
        'note_student',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function week()
    {
        return $this->belongsTo(ProjectWeek::class, 'week_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function files()
    {
        return $this->hasMany(TaskFile::class, 'task_id');
    }
}
