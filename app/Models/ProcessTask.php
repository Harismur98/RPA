<?php

namespace App\Models;

use App\Enums\ConditionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcessTask extends Model
{
    use HasFactory, SoftDeletes;

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
        'task_name',
        'step_id',
        'description',
        'confidence',
        'order',
        'is_stop_task',
        'value',
        'task_action',
        'condition_type',
        'create_by',
        'delete_by'
    ];

    protected $casts = [
        'confidence' => 'integer',
        'order' => 'integer',
        'is_stop_task' => 'boolean',
        'condition_type' => ConditionType::class
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
        return $this->hasMany(FileImg::class, 'process_task_id');
    }

    public function scopeNotDeleted($query)
    {
        return $query->where('delete_by', 1);
    }
}
