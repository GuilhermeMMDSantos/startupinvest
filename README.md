# StartupInvest

Plataforma de equity crowdfunding para startups angolanas. O sistema permite criar startups, abrir rodadas de captação, gerir investimentos, contratos, pagamentos, notificações e a área administrativa.

## Stack

- Backend: Java 21, Spring Boot 3.3, Spring Security, JPA, Flyway
- Frontend: React 18, TypeScript, Vite, Tailwind CSS
- Base de dados: PostgreSQL 16
- Infra: Docker e Docker Compose

## Funcionalidades

- Registo e autenticação de investidores e startups
- Aprovação administrativa de investidores e startups
- Criação e gestão de rodadas de investimento
- Supervisão de investimentos, pagamentos e contratos
- Notificações e mensagens internas
- Upload e leitura de ficheiros guardados no backend

## Arranque com Docker

```bash
cp .env.example .env
docker compose up --build
```

Depois abrir `http://localhost:8080`.

Serviços incluídos no `docker-compose.yml`:

- `db`: PostgreSQL com volume persistente
- `backend`: Spring Boot exposto apenas na rede interna do Compose
- `frontend`: React servido por nginx, com proxy de `/api` para o backend

Os uploads ficam no volume Docker `backend_uploads`, fora do código-fonte.

## Variáveis de ambiente

O ficheiro `.env.example` inclui os valores esperados pela stack:

- `DB_NAME`, `DB_USER`, `DB_PASSWORD`
- `JWT_SECRET`
- `ADMIN_EMAIL`, `ADMIN_PASSWORD`
- `WEB_PORT`
- `CORS_ORIGINS`
- `PAYPAL_BASE_URL`, `PAYPAL_CLIENT_ID`, `PAYPAL_CLIENT_SECRET`, `PAYPAL_CURRENCY`
- `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`

## Execução local

Backend:

```bash
cd backend
mvn spring-boot:run
```

Frontend:

```bash
cd frontend
npm install
npm run dev
```

O frontend em desenvolvimento corre em `http://localhost:5173` e faz proxy de `/api` para o backend.

## Endpoints úteis

- API: `http://localhost:8080/api`
- Swagger/OpenAPI: `http://localhost:8080/docs`
- Admin: `http://localhost:8080/admin`

## Estrutura

- `backend/` - API Spring Boot, domínio, serviços, segurança e migrações
- `frontend/` - aplicação React/Vite
- `docker-compose.yml` - orquestração local da stack
- `.env.example` - exemplo de variáveis de ambiente

## Observações

- O backend usa `ddl-auto=validate` e Flyway para a base de dados.
- O acesso à API no frontend é feito por `/api`, para evitar hardcode de hosts diferentes entre dev e Docker.
