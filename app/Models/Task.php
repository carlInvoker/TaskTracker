<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
         'title', 'description', 'status', 'user_id',
     ];

     protected $primaryKey = 'id';

     public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}
