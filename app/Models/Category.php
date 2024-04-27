<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'image', 'parent_id', 'type_id', 'is_parent', 'all_parents_ids'];

    protected $parentsIds;


    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->where('is_parent', true);
    }

    public function things(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->where('is_parent', false);
    }

    /**
     * The attributes that make product relationship
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
            get: fn ($value) => (new Carbon($value))->format('Y-m-d')
        );
    }
}
