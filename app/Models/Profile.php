<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class Profile extends Model
{
    protected $guarded = [];
    protected $dates = ['deleted_at'];
    use HasFactory;

    public function getRouteKeyName(){
        return 'slug';
    }
    public function users(){
        return $this->belongsTo('App\Models\User');
    }
    public function country(){
        return $this->belongsTo('App\Models\Country');
    }
    public function state(){
        return $this->belongsTo('App\Models\State');
    }
    public function city(){
        return $this->belongsTo('App\Models\City');
    }
}
