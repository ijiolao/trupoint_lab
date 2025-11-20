<?php

namespace App\Domain\Labs\DTOs;

class LabResultData
{
    public string $externalOrderRef;

    public string $status;

    public string $summary;

    public ?string $filePath;

    public function __construct(
        string $externalOrderRef,
        string $status,
        string $summary,
        ?string $filePath = null
    ) {
        $this->externalOrderRef = $externalOrderRef;
        $this->status = $status;
        $this->summary = $summary;
        $this->filePath = $filePath;
    }
}
