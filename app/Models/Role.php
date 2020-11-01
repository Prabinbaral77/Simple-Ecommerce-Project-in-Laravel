<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Role extends Model
{
    protected $guarded = [];
    protected $dates = ['deleted_at'];
    use HasFactory;

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
}
