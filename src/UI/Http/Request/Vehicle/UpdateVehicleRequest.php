<?php

declare(strict_types=1);

namespace App\UI\Http\Request\Vehicle;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UpdateVehicleRequest
{
    public function __construct(
        #[Assert\NotBlank()]
        #[Assert\Uuid]
        public string $model,
        #[Assert\NotBlank()]
        public string $registrationNumber,
    ) {
    }
}

