<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'image', 'parent_id', 'type_id', 'is_parent', 'all_parents_ids'];



    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * The attributes that make product relationship
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * The attributes that make product relationship
     */
    public function things()
    {
        return $this->hasMany(Thing::class);
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

    public function allParents()
    {
        $all_parents_ids = (explode(',', Category::find($this->id)->all_parents_ids));
        $parents = [];
        if (!is_null($all_parents_ids)) {
            foreach ($all_parents_ids as $singleId) {
                $category = Category::find($singleId);
                $parents[] = $category->name;
                // array_push($parents, $category->name);
            }
        }
        return $parents;
    }

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
