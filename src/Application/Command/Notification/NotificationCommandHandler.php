<?php

declare(strict_types=1);

namespace App\Application\Command\Notification;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;

#[AsMessageHandler]
final readonly class NotificationCommandHandler
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function __invoke(NotificationCommand $message): void
    {
        $email = (new Email())
            ->from($message->from)
            ->to($message->to)
            ->subject($message->subject)
            ->text($message->text);
        $this->mailer->send($email);
    }
}
