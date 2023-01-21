<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=['name','icon','is_active','description','parent_id','slug'];

      /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */


    public function getIsActiveAttribute($is_active)
    {
        return $is_active ? 'فعال': 'غیرفعال' ;
    }

    public function parent()
    {
        return $this->belongsTo($this,'parent_id')->with('parent') ;
    }

    public function children()
    {
        return $this->hasMany($this,'parent_id')->with('childeren');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class,'attribute_category');
    }
}
