<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'department_id',
    ];

    protected static function booting(){
        static::addGlobalScope('user', function(Builder $builder){
            if ( Auth()->user() )
                $builder->whereHas('department', function($query) {
                    $query->where('user_id', '=', Auth()->user()->id );
                });
        });
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }
}
