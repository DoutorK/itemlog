# ItemLog

Sistema para controle de departamentos e itens.

## Tecnologias Utilizadas
- Laravel (Backend/API)
- Vue 3 + TypeScript (Frontend)
- Vite (Build/Dev Server)
- Axios (HTTP requests)
- Docker (Banco de dados MySQL)

## Instalação e Execução

### 1. Clonar o repositório
```bash
git clone https://github.com/DoutorK/itemlog.git
cd itemlog
```

### 2. Instalar dependências do backend (Laravel)
```bash
composer install
```

### 3. Instalar dependências do frontend
```bash
npm install
```

### 4. Configurar variáveis de ambiente
Copie o arquivo `.env.example` para `.env` e ajuste as configurações conforme necessário.
```bash
cp .env.example .env
```

### 5. Subir banco de dados com Docker
```bash
docker-compose up -d
```

### 6. Gerar chave da aplicação
```bash
php artisan key:generate
```

### 7. Rodar as migrations
```bash
php artisan migrate
```

### 8. Iniciar o servidor de desenvolvimento
Backend:
```bash
php artisan serve
```
Frontend:
```bash
npm run dev
```

Acesse o projeto em `http://localhost:8000` (ou porta configurada pelo Vite, que o padrão desse projeto é a mesma do backend).

---

## Principais Endpoints da API

### Departamentos
- `GET /api/departments` — Lista todos os departamentos
- `POST /api/departments` — Cria um novo departamento
  - Body: `{ "name": "Nome do departamento" }`
- `GET /api/departments/{id}` — Exibe um departamento específico
- `PUT /api/departments/{id}` — Atualiza um departamento
  - Body: `{ "name": "Novo nome" }`
- `DELETE /api/departments/{id}` — Remove um departamento

### Itens
- `GET /api/items` — Lista todos os itens
- `POST /api/items` — Cria um novo item
  - Body: `{ "name": "Nome do item", "department_id": 1 }`
- `GET /api/items/{id}` — Exibe um item específico
- `PUT /api/items/{id}` — Atualiza um item
  - Body: `{ "name": "Novo nome", "department_id": 1 }`
- `DELETE /api/items/{id}` — Remove um item
- `GET /api/items/department/{departmentId}` — Lista itens de um departamento
- `POST /api/items/department/{departmentId}` — Cria item diretamente em um departamento
  - Body: `{ "name": "Nome do item" }`

---

## Observações
- O frontend consome a API via Axios.
- O projeto utiliza banco MySQL via Docker, mas pode ser adaptado para SQLite ou outro.
- Para dúvidas ou sugestões, consulte o repositório ou envie e-mail para suporte@itemlog.com.
