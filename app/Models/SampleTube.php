<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SampleTube extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sample_collection_id',
        'tube_type',
        'barcode',
        'status',
    ];

    /**
     * Get the sample collection for the tube.
     */
    public function sampleCollection(): BelongsTo
    {
        return $this->belongsTo(SampleCollection::class);
    }

    /**
     * Get the label for the sample tube.
     */
    public function sampleLabel(): HasOne
    {
        return $this->hasOne(SampleLabel::class);
    }
}
