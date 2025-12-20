<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectWeek extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'week_number',
        'sprint_title',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function tasks()
    {
        return $this->hasMany(ProjectTask::class, 'week_id');
    }

    // حساب start_date و end_date ديناميكياً
    public function getStartDateAttribute()
    {
        return $this->project->start_date->addDays(($this->week_number - 1) * 7);
    }

    public function getEndDateAttribute()
    {
        return $this->start_date->addDays(6);
    }
}
