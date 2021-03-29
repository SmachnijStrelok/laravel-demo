<?php
namespace App\Http\Services\Uploader\Entities;

class File
{
    private $path;
    private $size;
    private $originalName;
    private $mimeType;

    public function __construct(string $path, int $size, string $originalName, string $mimeType)
    {
        $this->path = $path;
        $this->size = $size;
        $this->originalName = $originalName;
        $this->mimeType = $mimeType;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }
}
