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

3. Install dependencies:
    ```bash
    composer install
    ```

4. Copy `.env.example` to `.env`:
    ```bash
    cp .env.example .env
    ```

5. Generate key:
    ```bash
    php artisan key:generate
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

Remember to replace the example requests and responses with the actual requests and responses of your API.

> **Note:** You need to have Docker installed and running to run the app.

## License

MIT

---

> Rumen Slavov &nbsp;&middot;&nbsp;
> GitHub [@B353N](https://github.com/B353N)
