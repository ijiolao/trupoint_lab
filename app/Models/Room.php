<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'clinic_location_id',
        'name',
        'is_active',
    ];

    /**
     * Get the clinic location that owns the room.
     */
    public function clinicLocation(): BelongsTo
    {
        return $this->belongsTo(ClinicLocation::class);
    }
}
