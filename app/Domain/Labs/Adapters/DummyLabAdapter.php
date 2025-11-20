<?php

namespace App\Domain\Labs\Adapters;

use App\Domain\Labs\Contracts\LabAdapter;
use App\Domain\Labs\DTOs\LabOrderData;
use App\Domain\Labs\DTOs\LabResultData;

class DummyLabAdapter implements LabAdapter
{
    public function createOrder(LabOrderData $data): string
    {
        return 'DUMMY-' . $data->orderId;
    }

    public function getOrderStatus(string $externalOrderRef): string
    {
        return 'in_progress';
    }

    public function fetchResults(string $externalOrderRef): ?LabResultData
    {
        return null;
    }

    public function handleWebhook(array $payload): ?LabResultData
    {
        if (! isset($payload['external_order_ref'], $payload['status'], $payload['summary'])) {
            return null;
        }

        return new LabResultData(
            $payload['external_order_ref'],
            $payload['status'],
            $payload['summary'],
            $payload['file_path'] ?? null
        );
    }
}
