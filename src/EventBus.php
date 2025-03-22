<?php
// src/EventBus.php

class EventBus {
    private $redis;
    private $defaultQueueKey;
    private const PRIORITY_HIGH = 'high';
    private const PRIORITY_LOW = 'low';

    public function __construct($host = '127.0.0.1', $port = 6379, $defaultQueueKey = 'event_queue') {
        $this->redis = new Redis();
        $this->redis->connect($host, $port);
        $this->defaultQueueKey = $defaultQueueKey;
    }

    public function publish($event, $data, $queueKey = null, $priority = self::PRIORITY_LOW) {
        if ($queueKey === null) {
            // Si no se especifica una cola, usar la prioridad para determinar la cola
            $queueKey = $this->defaultQueueKey . '_' . $priority;
        } else {
            $queueKey = $queueKey . '_' . $priority;
        }

        print_r("queueKey: " . $queueKey . "\n");
        $payload = json_encode(['event' => $event, 'data' => $data, 'priority' => $priority]);
        $this->redis->rPush($queueKey, $payload);  //es FIFO (First In First Out) cola 
        //Es útil para implementar colas de trabajo (FIFO) sin tener que hacer polling
    }

    public function subscribe($callback, $queueKey = null, $priority = null) {
        if ($queueKey === null && $priority !== null) {
            // Si no se especifica cola pero sí prioridad, usar la cola de esa prioridad
            $queueKey = $this->defaultQueueKey . '_' . $priority;
        } elseif ($queueKey === null) {
            $queueKey = $this->defaultQueueKey . '_' . self::PRIORITY_LOW;
        }

        while (true) {
            // BRPOP bloquea hasta que haya un mensaje disponible
            $result = $this->redis->brPop([$queueKey], 0);
            if ($result) {
                $message = json_decode($result[1], true);
                $callback($message);
            }
        }
    }

    public static function getPriorities() {
        return [self::PRIORITY_HIGH, self::PRIORITY_LOW];
    }
}
?>
