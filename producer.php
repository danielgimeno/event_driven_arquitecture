
<?php
// producer.php

require 'src/EventBus.php';

echo "Iniciando productor...\n";
$bus = new EventBus();
$counter = 0;

while (true) {
    $counter++;
    if ($counter % 2 == 0) {
        $bus->publish('nuevo_evento', ['contador' => $counter, 'timestamp' => time()], 'event_queue', 'high');
    } else {
        $bus->publish('nuevo_evento', ['contador' => $counter, 'timestamp' => time()], 'event_queue', 'low');
    }
    echo "Evento publicado: $counter\n";
    sleep(1);
}
?>