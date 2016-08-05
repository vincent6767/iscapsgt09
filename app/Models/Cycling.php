<?php

namespace Iscapsgt09\Models;

use Illuminate\Database\Eloquent\Model;

class Cycling extends Model
{
	const MINIMUMRPM = 40;
    protected $fillable = ['rpm', 'counter'];
    protected $table = 'cycling';

    /*
		Overwrite Method
    */

    public function save(array $options = []) {
    	if ($this->rpm > Self::MINIMUMRPM) {
    		$this->counter += 1;
    	}

    	parent::save();
    }
    public function calculatePoints() {
    	if ($this->counter >= 10) {
    		$this->update(['counter' => 0]);
    		return 10;
    	}
    	return 0;
    }
}
