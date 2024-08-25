<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessException extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'process_exceptions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exception_name',
        'confidence',
        'order',
        'is_loop',
        'is_stop_task',
        'value',
        'step_id',
    ];

    /**
     * Get the step that owns the process task.
     */
    public function step()
    {
        return $this->belongsTo(ProcessStep::class);
    }
}
