<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
    Model class for Taks
*/
class Task extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';

    public function __toString() {
        return (string)$this->user_class;
    }
}
