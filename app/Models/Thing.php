<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Thing extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'member_id', 'category_id', 'type_id'];

    /**
     * The attributes that make member relationship
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * The attributes that make category relationship
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The attributes that make type relationship
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }


    /**
    * Created by Attribute.
    *
    * @return Attribute
    */
    protected function createdBy(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => User::find($value)->name,
            set: fn ($value) => auth()->id(),
        );
    }

    /**
    * Created At Format Attribute.
    *
    * @return Attribute
    */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            // get: fn ($value) => (new Carbon($value))->format('Y-m-d')
        );
    }
}