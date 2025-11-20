<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SampleLabel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sample_tube_id',
        'label_payload',
        'printed_at',
    ];

    /**
     * Get the sample tube for the label.
     */
    public function sampleTube(): BelongsTo
    {
        return $this->belongsTo(SampleTube::class);
    }
}
