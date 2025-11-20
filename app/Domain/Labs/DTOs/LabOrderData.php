<?php

namespace App\Domain\Labs\DTOs;

use App\Models\Order;
use App\Models\PatientProfile;

class LabOrderData
{
    public int $orderId;

    public string $patientName;

    public ?string $patientDob;

    public ?string $patientIdentifier;

    /**
     * @var array<int, string>
     */
    public array $tests;

    public ?string $clinicLocationName;

    public function __construct(
        int $orderId,
        string $patientName,
        ?string $patientDob,
        ?string $patientIdentifier,
        array $tests,
        ?string $clinicLocationName
    ) {
        $this->orderId = $orderId;
        $this->patientName = $patientName;
        $this->patientDob = $patientDob;
        $this->patientIdentifier = $patientIdentifier;
        $this->tests = $tests;
        $this->clinicLocationName = $clinicLocationName;
    }

    public static function fromOrder(Order $order): self
    {
        $patient = $order->patient;
        $patientProfile = PatientProfile::where('user_id', $order->patient_id)->first();

        $tests = $order->orderItems->map(function ($item) use ($order) {
            $test = $item->test;

            $mapping = null;

            if ($test) {
                $mapping = $test->labTestMappings()
                    ->when($order->lab_partner_id, fn ($query) => $query->where('lab_partner_id', $order->lab_partner_id))
                    ->first();

                if (! $mapping) {
                    $mapping = $test->labTestMappings()->first();
                }
            }

            return $mapping?->external_code ?? $test?->name ?? '';
        })->filter()->values()->all();

        return new self(
            $order->id,
            $patient?->name ?? 'Unknown Patient',
            $patientProfile?->dob,
            $patientProfile?->nhs_number ?? (string) $order->patient_id,
            $tests,
            $order->appointment?->clinicLocation?->name
        );
    }
}
