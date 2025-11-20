<?php

namespace App\Domain\Labs\Contracts;

use App\Domain\Labs\DTOs\LabOrderData;
use App\Domain\Labs\DTOs\LabResultData;

interface LabAdapter
{
    public function createOrder(LabOrderData $data): string;

    public function getOrderStatus(string $externalOrderRef): string;

    public function fetchResults(string $externalOrderRef): ?LabResultData;

    public function handleWebhook(array $payload): ?LabResultData;
}
