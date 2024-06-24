# Todos API App

A test task for Todos API System.

## Table of Contents

- [Installation](#installation)
- [How To Use](#how-to-use)

## Installation

Follow these steps to install and run the project:

1. Clone the repository:
    ```bash
    git clone git@github.com:B353N/todosApp.git
    ```

2. Navigate into the repository:
    ```bash
    cd todosApp
    ```

3. Copy `.env.example` to `.env`:
    ```bash
    cp .env.example .env
    ```

4. Install dependencies:
    ```bash
    composer install
    ```



5. Generate key:
    ```bash
    ./vendor/bin/sail artisan key:generate
   ./vendor/bin/sail artisan jwt:secret
    ```

6. Run the app with sail:
    ```bash
    ./vendor/bin/sail up
    ```

7. Run migrations and seeders:
    ```bash
    ./vendor/bin/sail artisan migrate --seed
    ```

8. Run the tests:
    ```bash
    ./vendor/bin/sail test
    ```

## How To Use

This is an API-only application. You can use the following endpoints to interact with the app:

## API Endpoints

### Register a User

- **Endpoint:** `POST /api/register`
- **Request:**
    ```json
    {
        "name": "John Doe",
        "email": "john@example.com",
        "password": "password123"
    }
    ```
- **Response:**
    ```json
    {
        "status": "success",
        "message": "User created successfully",
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        },
        "authorisation": {
            "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
            "type": "bearer"
        }
    }
    ```

### Login a User

- **Endpoint:** `POST /api/login`
- **Request:**
    ```json
    {
        "email": "john@example.com",
        "password": "password123"
    }
    ```
- **Response:**
    ```json
    {
        "status": "success",
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        },
        "authorisation": {
            "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
            "type": "bearer"
        }
    }
    ```

### Create a Todo

- **Endpoint:** `POST /api/todos`
- **Request:**
    ```json
    {
        "title": "Buy groceries",
        "description": "Milk, eggs, bread",
        "status": "pending"
    }
    ```
- **Response:**
    ```json
    {
        "status": "success",
        "message": "Todo created successfully",
        "data": {
            "id": 1,
            "title": "Buy groceries",
            "description": "Milk, eggs, bread",
            "status": "pending",
            "user_id": 1
        }
    }
  
  
    ```
  ### Get All Todos

- **Endpoint:** `GET /api/todos`
- **Request:**
    ```bash
    GET /api/todos?filter[status]=pending
    ```
- **Response:**
    ```json
    {
        "status": "success",
        "data": [
            {
                "id": 1,
                "title": "Buy groceries",
                "description": "Milk, eggs, bread",
                "status": "pending",
                "user_id": 1
            },
            {
                "id": 2,
                "title": "Walk the dog",
                "description": "",
                "status": "pending",
                "user_id": 1
            }
        ]
    }
    ```

In this example, the `filter[status]=pending` query parameter is used to only return todos with a status of "pending". Replace the example request and response with the actual request and response of your API.
You can filter by `status`, `title` and `description` fields.
Also you can sort by `status`, `title` and `created_at` fields.
```bash
# Sort by status
GET /api/todos?sort=status

# Sort by title
GET /api/todos?sort=title

# Sort by created_at
GET /api/todos?sort=created_at

# Filter by status
GET /api/todos?filter[status]=pending

# Filter by title
GET /api/todos?filter[title]=Buy groceries

# Filter by description
GET /api/todos?filter[description]=Milk, eggs, bread
```

## Pagination

You can paginate the results by using the `page` query parameter. The default number of items per page is 20. You can change this by using the `per_page` query parameter.
Maximun number of items per page is 100.

```bash
# Get the first page of todos
GET /api/todos?page[number]=1

```

Remember to replace the example requests and responses with the actual requests and responses of your API.

> **Note:** You need to have Docker installed and running to run the app.

## License

MIT

---

> Rumen Slavov &nbsp;&middot;&nbsp;
> GitHub [@B353N](https://github.com/B353N)
