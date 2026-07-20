# startupInveste

Plataforma de equity-crowdfunding que liga startups angolanas a investidores. Startups criam perfil e rodadas de captação; investidores navegam oportunidades, investem e assinam contratos digitalmente.

## Stack

- Laravel 7 (PHP 7.4)
- MySQL 8 + Redis
- Bootstrap 5 + React (Laravel Mix) para as partes reactivas do Blade
- Pusher / Laravel WebSockets para notificações e mensagens em tempo real
- PayPal SDK para pagamentos

## Requisitos

- Docker e Docker Compose

## A correr com Docker

```bash
cp .env.example .env
docker compose up --build
```

Depois, num segundo terminal:

```bash
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
```

A aplicação fica disponível em `http://localhost:8000`.

Serviços definidos no `docker-compose.yml`:

| Serviço | Função |
|---|---|
| `app` | PHP-FPM (Laravel) |
| `nginx` | Servidor web, porta `8000` |
| `mysql` | Base de dados |
| `redis` | Cache / filas |
| `queue` | Worker de filas (`queue:work`) |
| `websockets` | Servidor de websockets (`laravel-websockets`), porta `6001` |

## A correr sem Docker

```bash
composer install
npm install && npm run dev
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Para notificações/mensagens em tempo real, correr também:

```bash
php artisan websockets:serve
php artisan queue:work
```

## Build de assets

```bash
npm run dev     # desenvolvimento
npm run watch   # recompila em cada alteração
npm run prod    # build de produção
```

## Estrutura

- `app/` — models, controllers, services
- `resources/views/` — Blade
- `resources/js/` — JS/React, `resources/sass/` — estilos
- `docker/` — configuração de nginx e PHP para os containers
