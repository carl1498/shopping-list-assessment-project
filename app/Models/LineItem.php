<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LineItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'line_item_id';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'line_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'quantity',
        'purchased',
        'item_id'
    ];

    /**
     * Perform any actions required before the model boots.
     *
     * @return void
     */
    protected static function booting(){
        // Ensure the line item is unique against the user
        static::addGlobalScope('user', function(Builder $builder){
            if ( Auth()->user() )
                $builder->whereHas('item', function($query) {
                    $query->whereHas('department', function($subQuery) {
                        $subQuery->where('user_id', '=', Auth()->user()->id );
                    });
                });
        });
    }

    /**
     * Get the item that owns the line item.
     */
    public function item(){
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }
}
