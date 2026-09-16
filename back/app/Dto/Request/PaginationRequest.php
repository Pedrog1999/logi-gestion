<?php 

namespace App\Dto\Request;

final readonly class PaginationRequest {
    public function __construct(
        private int $page,
        private int $size
    ) {}

    public function getPage(): int
    {
        return $this->page;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getLimit(): int
    {
        return $this->size;
    }

    public function getOffset(): int
    {
        return ($this->page - 1) * $this->size;
    }
}