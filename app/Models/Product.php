<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;

class Product extends Model
{
    protected $guarded = [];
    protected $dates = ['deleted_at'];
    use HasFactory;
    use SoftDeletes;

    public function categories(){
        return $this->belongsToMany("App\Models\Category");
    }

    public function getRouteKeyName(){
        return 'slug';
    }
}
