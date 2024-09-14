<?php

declare(strict_types=1);

namespace App\Application\Command\Notification;

final readonly class NotificationCommand
{
    public function __construct(
        public string $from,
        public string $to,
        public string $subject,
        public string $text,
    ) {
    }
}
