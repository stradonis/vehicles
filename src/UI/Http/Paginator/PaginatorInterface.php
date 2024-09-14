<?php

namespace App\UI\Http\Paginator;

interface PaginatorInterface
{
    public function getPage(): int;
    public function getItemsPerPage(): int;
    public function getOffset(): int;
    public function getNumberOfPages(int $totalRows): int;
}