<?php

namespace Iscapsgt09\Models;

use Illuminate\Database\Eloquent\Model;

class CyclingSession extends Model
{
	protected $fillable = ['start_time', 'user_id'];

	public $timestamps = false;

    public static function start($user) {
    	$newSession['start_time'] = (new \DateTime('now'))->format('Y-m-d H:i:s');
    	$newSession['user_id'] = $user->id;

    	return Self::create($newSession);
    }
    function stop() {
    	$this->finish_time = (new \DateTime())->format('Y-m-d H:i:s');

    	$this->save();
    }
}
