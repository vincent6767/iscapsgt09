<?php

namespace Iscapsgt09\Models;

use Illuminate\Database\Eloquent\Model;

class TestingCycling extends Model
{
    protected $table = 'testing_cycling';
    protected $fillable = ['user_id', 'rpm', 'date_retrieved'];

    public $timestamps = false;
    public $incrementing = false;
}
