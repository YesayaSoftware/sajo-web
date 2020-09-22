<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title', 
        'description', 
        'completed', 
        'owner_id'
    ];

    protected $with = ['owner'];

    /**
     * Mark the given task as the complete.
     *
     * @param Boolean $completed
     */
    public function complete($completed)
    {
        $this->update(['completed' => $completed]);

        return $this;
    }

    /**
     * Task is owned by a particularß user.
     * 
     * @return BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }   
}
