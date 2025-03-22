# Arquitectura Dirigida por Eventos con PHP y Redis

Este repositorio demuestra una **Arquitectura Dirigida por Eventos** utilizando **PHP** y **Redis** como bus de eventos.

## 📌 Características
- Implementa un modelo **Productor-Consumidor** usando Redis.
- Utiliza **Redis Pub/Sub** para comunicación en tiempo real.
- Incluye un **productor** que emite eventos cada segundo.
- Incluye un **consumidor** que escucha y procesa eventos.

## 🚀 Instalación y Configuración

### 1️⃣ Instalar Redis con Docker
Si Redis no está instalado, puedes ejecutarlo en un contenedor Docker con el siguiente comando:
```sh
docker run --name redis-server -d -p 6379:6379 redis
```
Esto hará lo siguiente:
- Descarga la imagen oficial de Redis si aún no la tienes.
- Inicia un contenedor en modo **detached** (`-d`).
- Mapea el puerto `6379` del contenedor al sistema anfitrión.

Para verificar que Redis está corriendo, usa:
```sh
docker ps | grep redis
```
Si el contenedor no aparece, inícialo con:
```sh
docker start redis-server
```

### 2️⃣ Instalar Dependencias
Asegúrate de tener **Composer** instalado y luego ejecuta:
```sh
composer install
```

### 3️⃣ Conectar Redis con PHP
Cuando usas Redis en Docker, en el código PHP debes conectarte al nombre del contenedor (`redis-server`) en lugar de `localhost`. Ejemplo:
```php
$redis = new Predis\Client([
    'scheme' => 'tcp',
    'host'   => 'redis-server',
    'port'   => 6379,
]);
```
Si ejecutas PHP fuera de Docker en Windows o Mac, usa `'host.docker.internal'` como host.

## 🛠 Ejecutar la Aplicación

### Iniciar el Productor (Emisor de Eventos)
```sh
php producer.php
```
Este publicará un evento cada segundo en el canal de Redis.

### Iniciar el Consumidor (Escucha de Eventos)
```sh
php consumer.php high
php consumer.php low
```
Este se suscribirá y procesará eventos en tiempo real.

## 📜 Estructura del Proyecto
```
.
├── src/
│   ├── EventBus.php   # Maneja las operaciones de Redis Pub/Sub
├── producer.php       # Publica eventos en Redis
├── consumer.php       # Se suscribe y procesa eventos
├── composer.json      # Dependencias de Composer
├── test_connect.php   # verificador de que la servicio de redis esta ok  
└── README.md          # Documentación del proyecto
```

## 🏗 Mejoras Futuras
- Implementar múltiples consumidores para balanceo de carga.
- Introducir filtrado de eventos por tipo.
- Usar Docker Compose para una mejor gestión del entorno.

## 📝 Licencia
Este proyecto está bajo la licencia MIT. Puedes modificarlo y usarlo según tus necesidades.

---

🚀 **¡Feliz Programación!** 🎯

