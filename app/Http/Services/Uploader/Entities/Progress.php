<?php
namespace App\Http\Services\Uploader\Entities;

class Progress
{
    private $percentage;
    private $status;

    public function __construct(int $percentage, bool $status)
    {
        $this->percentage = $percentage;
        $this->status = $status;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function getPercentage(): int
    {
        return $this->percentage;
    }

    public function __toString()
    {
        $data = [
            'percentage' => $this->getPercentage(),
            'status' => $this->getStatus()
        ];

        return json_encode($data);
    }
}
