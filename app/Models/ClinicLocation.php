<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClinicLocation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address_line1',
        'city',
        'postcode',
        'timezone',
        'is_active',
    ];

    /**
     * Get the rooms for the clinic location.
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
}
