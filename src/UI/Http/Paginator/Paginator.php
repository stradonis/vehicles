<?php

namespace App\UI\Http\Paginator;
class Paginator implements PaginatorInterface
{
    public const PAGE_NUMBER = 1;
    public const ITEMS_PER_PAGE = 20;

    private int $page;
    private int $offset = 0;

    public function __construct(?int $page = null)
    {
        $this->page = $page ?? self::PAGE_NUMBER;
        $this->offset();
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getItemsPerPage(): int
    {
        return self::ITEMS_PER_PAGE;
    }

    private function offset(): void
    {
        $this->offset = ($this->page - 1) * $this->getItemsPerPage();
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getNumberOfPages(int $totalRows): int
    {
        return (int) ceil($totalRows / $this->getItemsPerPage());
    }
}