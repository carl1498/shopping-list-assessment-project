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
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'item_id';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'items';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'department_id',
    ];

    /**
     * Perform any actions required before the model boots.
     *
     * @return void
     */
    protected static function booting() {
        // Ensure the item is unique against the user
        static::addGlobalScope('user', function(Builder $builder){
            if ( Auth()->user() )
                $builder->whereHas('department', function($query) {
                    $query->where('user_id', '=', Auth()->user()->id );
                });
        });
    }

    /**
     * Get the department that owns the item.
     */
    public function department() {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }
}
