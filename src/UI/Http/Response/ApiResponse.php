<?php

namespace App\UI\Http\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    private string $uuid;
    private int $code = Response::HTTP_OK;
    private string $error;
    private int $totalPages;
    private array $data;
    public function withUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function withTotalCount(int $totalCount): self
    {
        $this->totalPages = $totalCount;

        return $this;
    }

    public function withData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function withCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function withError(string $error): self
    {
        $this->error = $error;

        return $this;
    }

    public function response(): JsonResponse
    {
        $data = [];

        if (!empty($this->error)) {
            $data['detail'] = $this->error;
        }

        if (!empty($this->uuid)) {
            $data['id'] = $this->uuid;
        }

        if (!empty($this->data)) {
            $data['data'] = $this->data;
        }

        if (!empty($this->totalPages)) {
            $data['totalPages'] = $this->totalPages;
        }

        return new JsonResponse(
            $data,
            $this->code
        );
    }
}