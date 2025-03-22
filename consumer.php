<?php
// consumer.php

require 'src/EventBus.php';

// Get priority from command line argument, default to 'low' if not specified
$priority = isset($argv[1]) ? strtolower($argv[1]) : 'low';

// Validate priority input
if (!in_array($priority, ['low', 'high'])) {
    die("Error: Priority must be either 'low' or 'high'\n");
}

echo "Esperando eventos de prioridad '$priority'...\n";
$bus = new EventBus();

$bus->subscribe(
    function ($message) use ($priority) {
    // Only process messages matching the specified priority
        if (isset($message['priority']) && $message['priority'] === $priority) {
            echo "Evento recibido: " . json_encode($message) . "\n";
        }
    },
    null,
    $priority
);
?>
