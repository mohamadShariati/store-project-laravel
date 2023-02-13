<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded=[];
    protected $table='banners';

    public function getIsActiveAttribute($is_active)
    {
        return $is_active ? 'فعال': 'غیرفعال' ;
    }
}
