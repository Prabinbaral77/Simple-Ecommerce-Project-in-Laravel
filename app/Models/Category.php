<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;

class Category extends Model
{
    protected $guarded = [];
    protected $dates = ['deleted_at'];
    use HasFactory;
    use SoftDeletes;

    public function products(){
        return $this->belongsToMany("App\Models\Product");
    }

    public function childrens(){
        return $this->belongsToMany(Category::class,'category_parent','category_id','parent_id');
    }
}
