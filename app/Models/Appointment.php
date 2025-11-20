<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Appointment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'clinic_location_id',
        'room_id',
        'patient_id',
        'scheduled_at',
        'status',
        'check_in_at',
        'completed_at',
    ];

    /**
     * Get the clinic location for the appointment.
     */
    public function clinicLocation(): BelongsTo
    {
        return $this->belongsTo(ClinicLocation::class);
    }

    /**
     * Get the room for the appointment.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the patient for the appointment.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /**
     * Get the order associated with the appointment.
     */
    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }
}
