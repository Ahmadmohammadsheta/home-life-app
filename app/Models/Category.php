<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Http\Traits\ImageProccessingTrait;

class Category extends Model
{
    use HasFactory, ImageProccessingTrait;
    protected $fillable = ['name', 'image', 'parent_id', 'type_id', 'is_parent', 'all_parents_ids'];

    protected $parentsIds;


    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->whereIsParent(true);
    }

    public function things(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->whereIsParent(false);
    }

    /**
     * The attributes that make type relationship
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
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
            get: fn ($value) => (new Carbon($value))->format('Y-m-d')
        );
    }

    /**
    * Created At Format Attribute.
    *
    * @return Attribute
    */
    protected function image(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $this->setImage($value, 'categories'),
            get: fn ($value) => $this->getImage($value, 'categories')
        );
    }

    /**
    * Get Type Name Attribute.
    *
    * @return Attribute
    */
    protected function typeName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->type->name,
        );
    }

    /**
    * Get Type Name Attribute.
    *
    * @return Attribute
    */
    protected function isParent(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value == 1 ? 'True' : 'False',
        );
    }

    /**
    * Get parent Name Attribute.
    *
    * @return Attribute
    */
    protected function parentName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->parent_id == null ? 'Non' : $this->parent->name,
        );
    }

}
