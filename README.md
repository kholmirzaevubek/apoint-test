### Technologies

- Laravel 12, PHP 8.2, PHP-FPM
- MySQL 8, Redis 8.2
- Docker, docker-compose, Nginx

### Quick Start

#### 1. Copy environment file
```bash
cp .env.example .env
```

#### 2. Start containers

```bash
docker compose up -d --build
```

#### 3. Install dependencies

```bash
docker compose exec app composer install
docker compose exec app php artisan key:generate
```

#### 4. Ensure Queue is running

```bash
docker logs apointsms-queue
```
#### 5. Access the app

- **App**: http://localhost:8000


---

# 📌 API Endpoints

---

## 1️⃣ Create Project

Creates a new project and assigns an SMS provider.

### Endpoint

```
POST /api/projects
```

### Request Body

```json
{
  "name": "E-commerce",
  "description": "Online shop project",
  "provider": "eskiz"
}
```

### Response (201 Created)

```json
{
  "id": 1,
  "name": "E-commerce",
  "description": "Online shop project",
  "provider": "eskiz",
  "api_key": "generated_api_key_here",
  "created_at": "2026-03-01T10:00:00Z"
}
```

---

## 2️⃣ Send SMS

Queues one or multiple SMS messages for sending.

### Endpoint

```
POST /api/sms/send
```

### Request Body

```json
{
  "api_key": "PROJECT_API_KEY",
  "phones": ["+998901234567"],
  "message": "Test SMS"
}
```

### Response (202 Accepted)

```json
{
  "queued": 1,
  "message_ids": [1]
}
```

SMS sending is processed in the background via a queue worker.

---

## 3️⃣ SMS History

Returns the paginated SMS history for the project.

### Endpoint

```
GET /api/sms/history
```

### Query Parameters

Parameter
api_key	-> Project API key (required)
status -> pending / sent / delivered / failed
phone -> Filter by phone number
from -> Start date (YYYY-MM-DD)
to -> End date (YYYY-MM-DD)

### Example Request

```
GET /api/sms/history?api_key=PROJECT_API_KEY&status=sent
```

---
