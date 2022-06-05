<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ["user_id", "slug"];

    protected static function booting(){

        self::creating( function($model){
            $model->setSlug();
            $model->user_id = Auth()->user()
                ? Auth()->user()->id
                : $model->user_id;
        }  );
        self::updating( fn($model) => $model->setSlug() );

        static::addGlobalScope('user', function(Builder $builder){
            if ( Auth()->user() )
                $builder->where('user_id', '=', Auth()->user()->id );
        });
    }

    protected function setSlug(){

        $this->slug = preg_replace("/[^0-9a-zA-Z]{1,}/", "-", $this->name );
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function items(){
        return $this->hasMany(Item::class);
    }
}
