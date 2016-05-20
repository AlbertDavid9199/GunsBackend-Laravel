<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'states';
    protected $primaryKey = 'state_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'user_id', 'nra_state', 'notify_state', 'active'];
}
