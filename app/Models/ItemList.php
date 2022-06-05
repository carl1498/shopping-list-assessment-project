<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemList extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'item_list';

    protected $fillable = [
        'quantity',
        'purchased',
        'item_id'
    ];

    protected static function booting(){
        static::addGlobalScope('user', function(Builder $builder){
            if ( Auth()->user() )
                $builder->whereHas('item', function($query) {
                    $query->whereHas('department', function($subQuery) {
                        $subQuery->where('user_id', '=', Auth()->user()->id );
                    });
                });
        });
    }

    public function item(){
        return $this->belongsTo(Item::class);
    }
}
