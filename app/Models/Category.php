<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'parent_id', 'type_id'];



    /**
     * The attributes that make product relationship
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }


    /**
    * Get Type Name Attribute.
    *
    * @return Attribute
    */
    // protected function typeId(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => Type::find($value)->name,
    //     );
    // }

    /**
    * Get User Attribute.
    *
    * @return Attribute
    */
    // protected function userId(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => User::find($value)->name,
    //     );
    // }

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
            get: fn ($value) => (new Carbon($value))->format('Y-m-d')
        );
    }
}
