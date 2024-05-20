<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type_id', 'user_id'];

    protected $attributes;

    public function __construct(array $attributes = array())
    {
        $this->setRawAttributes(array(
        'user_id' => auth()->id()), true);
        parent::__construct($attributes);
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
    * Get Type Name Attribute.
    *
    * @return Attribute
    */
    protected function typeId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Type::find($value)->name,
        );
    }

    /**
    * User Id Attribute.
    *
    * @return Attribute
    */
    protected function userId(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value = auth()->id(),
            get: fn ($value) => User::find($value)->name,
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
