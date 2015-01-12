#!/usr/bin/php
<?php
if (!isset($argv[1])) {
    $io = fopen('php://stderr', 'w+');
    fwrite($io, "usage: php event-publisher.php <nbevents:int>\n");
    die;
}

require_once __DIR__ . '/../vendor/autoload.php';

$queueService = new \Burrow\RabbitMQ\AmqpExchangeService('127.0.0.1', 5672, 'guest', 'guest', 'xchange');
$queueService->addQueue('app1');

$serializer = new \Evaneos\Events\EventSerializer();
$serializer->bindSerializer('test.simple', new \Evaneos\Events\Example\TestEventSerializer());

$eventPublisher = new \Evaneos\Events\Publishers\MessageQueue\MessageQueueEventPublisher($queueService, $serializer);

for ($i = 0; $i < $argv[1]; ++$i) {
    $eventPublisher->publish(new \Evaneos\Events\Example\TestEvent($i));
}
