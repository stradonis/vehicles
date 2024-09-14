<?php

namespace App\Infrastructure\Serializer;

use App\Application\Command\Notification\NotificationCommand;
use Exception;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class NotificationJsonMessageSerializer implements SerializerInterface
{
    public function decode(array $encodedEnvelope): Envelope
    {
        $body = $encodedEnvelope['body'];
        $headers = $encodedEnvelope['headers'];

        $data = json_decode($body, true);
        $message = new NotificationCommand($data['from'], $data['to'], $data['subject'], $data['text']);

        $stamps = $headers['stamps'] ? unserialize($headers['stamps']) : [];

        return new Envelope($message, $stamps);
    }


    /**
     * @throws Exception
     */
    public function encode(Envelope $envelope): array
    {
        $message = $envelope->getMessage();

        if (!$message instanceof NotificationCommand) {
            throw new Exception('Unsupported message class');
        }

        $data = [
            'from' => $message->from,
            'to' => $message->to,
            'subject' => $message->subject,
            'text' => $message->text
        ];

        $allStamps = [];

        foreach ($envelope->all() as $stamps) {
            $allStamps = array_merge($allStamps, $stamps);
        }

        return [
            'body' => json_encode($data),
            'headers' => [
                'stamps' => serialize($allStamps)
            ],
        ];
    }
}