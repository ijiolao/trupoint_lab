<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabTestMapping extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'test_id',
        'lab_partner_id',
        'external_code',
        'default_turnaround_days',
    ];

    /**
     * Get the test that owns the mapping.
     */
    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }
}
