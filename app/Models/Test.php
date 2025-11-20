<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Test extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'test_category_id',
        'name',
        'description',
        'default_price',
    ];

    /**
     * Get the category that owns the test.
     */
    public function testCategory(): BelongsTo
    {
        return $this->belongsTo(TestCategory::class);
    }

    /**
     * The panels that include the test.
     */
    public function testPanels(): BelongsToMany
    {
        return $this->belongsToMany(TestPanel::class, 'panel_test');
    }

    /**
     * Get the lab test mappings for the test.
     */
    public function labTestMappings(): HasMany
    {
        return $this->hasMany(LabTestMapping::class);
    }
}
