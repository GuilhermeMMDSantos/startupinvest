# StartupInvest

Aplicação Laravel para ligar startups a investidores. Inclui cadastro e perfis, rondas de captação, mensagens, notificações e fluxos de pagamento.

## Stack

- Laravel 7 e PHP 7.4
- PostgreSQL 16
- Apache para servir a aplicação em produção
- Blade e Bootstrap para a interface
- Pusher, SMTP e PayPal para funcionalidades externas que dependem desses serviços

Node.js/npm não são necessários para iniciar a aplicação. O Bootstrap e os recursos frontend já estão no projeto.

## Requisitos

- Docker Engine
- Docker Compose v2 (`docker compose`)

Não é necessário instalar PHP, Composer ou PostgreSQL no computador anfitrião para usar a configuração Docker.

## Desenvolvimento

Na raiz do projeto:

```bash
cp -n .env.example .env
APP_UID=$(id -u) APP_GID=$(id -g) docker compose up --build -d
```

Se `APP_KEY` estiver vazio em `.env`, gere uma chave:

```bash
docker compose exec app php artisan key:generate
```

Crie o esquema do banco e o link público dos arquivos:

```bash
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
docker compose exec app php artisan storage:link
```

A aplicação fica disponível em <http://localhost:8000>. O PostgreSQL fica disponível no computador anfitrião em `127.0.0.1:5432`; dentro do Docker, a aplicação conecta ao serviço `db`.

Antes de executar `db:seed`, defina `ADMIN_EMAIL` e `ADMIN_PASSWORD` em `.env`. O seeder cria uma conta de administrador aprovada (`tipo=admin`, `estado=aceite`); não há senha padrão no código. Se essa conta já existir, a senha não é alterada ao repetir o seed.

Comandos úteis:

```bash
docker compose logs -f app db
docker compose exec app sh
docker compose exec app ./vendor/bin/phpunit
docker compose down
```

O banco persiste num volume Docker. Durante o desenvolvimento, os arquivos enviados ficam em `storage/` no diretório local do projeto, montado no container. `docker compose down` preserva esses dados; `docker compose down -v` remove os volumes Docker.

## Produção

Crie o arquivo de ambiente de produção a partir do exemplo:

```bash
cp .env.production.example .env.production
```

Edite `.env.production` e defina:

- `APP_KEY`: uma chave Laravel única, gerada com `php artisan key:generate --show`.
- `APP_URL`: o endereço público da aplicação, por exemplo `https://startup.example.com`.
- `DB_DATABASE`, `DB_USERNAME` e `DB_PASSWORD`: valores próprios e uma senha forte.
- `ADMIN_EMAIL` e `ADMIN_PASSWORD`: email e senha forte para a conta administrativa inicial.

O arquivo `.env.production` está excluído do Git. Não coloque credenciais no repositório.

Construa e inicie os serviços e aplique as migrations:

```bash
docker compose --env-file .env.production -f docker-compose.prod.yml up --build -d
docker compose --env-file .env.production -f docker-compose.prod.yml exec app php artisan migrate --force
docker compose --env-file .env.production -f docker-compose.prod.yml exec app php artisan db:seed --force
```

A aplicação é publicada na porta `8080` por padrão. Para escolher outra porta, defina `APP_PORT` no ambiente do comando Compose. O PostgreSQL não publica uma porta no host em produção. O banco e os arquivos enviados são persistidos em volumes Docker.

Para acompanhar os serviços ou desligá-los:

```bash
docker compose --env-file .env.production -f docker-compose.prod.yml logs -f
docker compose --env-file .env.production -f docker-compose.prod.yml down
```

Não use `down -v` se quiser conservar o banco e os arquivos enviados.

## Banco de dados e migrations

As migrations em `database/migrations` criam a estrutura do banco PostgreSQL. Depois de iniciar o serviço, aplique-as com `php artisan migrate` (em produção, use `--force`).

O arquivo `startup_invest.sql` é um dump do banco antigo em MySQL/MariaDB. A configuração Docker não importa esse dump nem transfere os dados: a migração de dados para PostgreSQL deve ser feita separadamente.

## Serviços externos

O projeto tem integrações com Pusher, SMTP e PayPal. Configure as respectivas variáveis de ambiente antes de usar essas funcionalidades. Elas são serviços externos e não fazem parte dos dois containers deste Compose.

## Nota de suporte

Laravel 7 e PHP 7.4 já não recebem atualizações de segurança. A imagem está alinhada com a versão de PHP declarada pelo projeto, mas este stack deve ser atualizado antes de uma implantação pública em produção.
