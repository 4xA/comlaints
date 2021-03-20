<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'taggable_type',
        'taggable_id'
    ];

    public function complaints()
    {
        return $this->morphedByMany(Complaint::class, 'taggable');
    }
}
