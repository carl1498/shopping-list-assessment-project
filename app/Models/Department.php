<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'department_id';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'departments';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['user_id', 'slug'];

    /**
     * Perform any actions required before the model boots.
     *
     * @return void
     */
    protected static function booting(){
        // Set the slug everytime the model is being created
        self::creating( function($model){
            $model->setSlug();
            $model->user_id = Auth()->user()
                ? Auth()->user()->id
                : $model->user_id;
        }  );
        
        // Update the slug everytime the model is being updated
        self::updating( fn($model) => $model->setSlug() );

        // Ensure the department is unique against the user
        static::addGlobalScope('user', function(Builder $builder){
            if ( Auth()->user() )
                $builder->where('user_id', Auth()->user()->id);
        });
    }

    /**
     * Sets a slug for the model
     * 
     */
    protected function setSlug() {
        $this->slug = Str::slug($this->name, '-');
    }

    /**
     * Get the user that owns the department.
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items for the department.
     */
    public function items() {
        return $this->hasMany(Item::class, 'department_id');
    }
}
