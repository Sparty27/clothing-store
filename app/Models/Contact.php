<?php

namespace App\Models;

use App\Enums\ContactEnum;
use App\Observers\ContactObserver;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(ContactObserver::class)]
class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'data',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'type' => ContactEnum::class,
        'data' => 'array'
    ];

    public function scopePhone(Builder $query)
    {
        return $query->where('type', ContactEnum::PHONE);
    }

    public function scopeEmail(Builder $query)
    {
        return $query->where('type', ContactEnum::EMAIL);
    }

    public function scopeAddress(Builder $query)
    {
        return $query->where('type', ContactEnum::ADDRESS);
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSelectedType(Builder $query, $type)
    {
        if ($type instanceof ContactEnum) {
            return $query->where('type', $type);
        }

        if (is_string($type)) {
            $contact = ContactEnum::tryFrom($type);

            if ($contact) {
                return $query->where('type', $contact);
            }
        }
    }
}
