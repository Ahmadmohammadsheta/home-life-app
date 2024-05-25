<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Http\Traits\ImageProccessingTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, ImageProccessingTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image',
        'parent_id',
        'type_id',
        'is_parent',
        'all_parents_ids'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_parent' => 'boolean',
        'all_parents_ids' => 'string',
    ];


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
     * Filter Scope
     */
    public function scopeFilter(Builder $query, array $filters):void
    {
        // $filters['name'] ?? null means if $filters['name'] == null return null
        $query->when($filters['name'] ?? null, function ($query, $search) {
            $query->where('categories.name', 'LIKE', "%$search%");
        });

        $query->when($filters['is_parent'] ?? null, function ($query, $search) {
            $query->where('categories.is_parent', $search);
        });
    }

    /**
     * Filter Scope
     */
    public function scopeIsParentDesc(Builder $query):void
    {
        // $filters['name'] ?? null means if $filters['name'] == null return null
        $query->orderBy('categories.is_parent');
    }

    /**
     * Scope a query to only include popular users.
     */
    public function scopePopular(Builder $query): void
    {
        $query->where('votes', '>', 100);
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
    protected function isParentStatus(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->is_parent  == 1 ? 'True' : 'False',
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
