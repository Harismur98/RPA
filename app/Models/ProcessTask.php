<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessTask extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'processtasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_action',
        'task_name',
        'confidence',
        'order',
        'is_loop',
        'is_stop_task',
        'value',
        'step_id',
        'delete_by',
        'create_by',
        'description',
    ];

    /**
     * Get the step that owns the process task.
     */
    public function step()
    {
        return $this->belongsTo(ProcessStep::class);
    }

    public function img()
    {
        return $this->hasMany(Fileimg::class);
    }

    public function scopeNotDeleted($query)
    {
        return $query->where('delete_by', 1);
    }
}
