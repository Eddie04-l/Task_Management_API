# Task API

## Overview
Simple RESTful API built with Laravel 10 and Sanctum for authentication. Features user register/login, CRUD for tasks (per-user), status filter, and pagination.

## Setup
1. Clone repo
2. Run `composer install`
3. Copy `.env.example` to `.env` and set DB credentials. Create a `.env` file for this.
4. create database `tasks_mgt` and set DB_CONNECTION=mysql
6. Run `php artisan key:generate`
7. Run `php artisan migrate`
8. Run `php artisan serve`

## API Endpoints
- POST /api/register {name,email,password}
- POST /api/login {email,password}
- POST /api/logout (auth)
Tasks
- GET /api/tasks?status=pending&per_page=10 (auth) - View all tasks for a particular user
- POST /api/tasks {title, description, status} (auth) - save tasks for a particular user
- GET /api/tasks/{id} (auth) - View tasks for a particular user using id
- PUT /api/tasks/{id} {title, description, status} (auth) - View tasks for a particular user using id and also filtering (actually filtering can come in with or without id)
- DELETE /api/tasks/{id} (auth) - Deletes a particular task

## Testing
Run `php artisan test`.

## Approach
- Sanctum token-based API authentication for simplicity.
- Form Requests for validation and clear error messages.
- Task ownership enforced in controller before actions.
- Bonus: status filter & pagination implemented on the index endpoint.

## API DOCUMENTATIONS

API Documentation

# Authentication Endpoints
Register User
URL: POST /api/register

Authentication: None

Body:

json
{
  "name": "Confidence Edwin",
  "email": "ce@example.com",
  "password": "password",
}
Response:

json
{
  "user": {
    "id": 1,
    "name": "Confidence Edwin",
    "email": "ce@example.com",
    "created_at": "2023-01-01T00:00:00.000000Z",
    "updated_at": "2023-01-01T00:00:00.000000Z"
  },
  "token": "token"
}
Login
URL: POST /api/login

Authentication: None

Body:

json
{
  "email": "ce@example.com",
  "password": "password"
}
Response: Same as register

Logout
URL: POST /api/logout

Authentication: Bearer Token required

Headers: Authorization: Bearer {token}

Response:

json
{
  "message": "Logged out"
}

# Task Endpoints
All task endpoints require Bearer Token authentication.

# List Tasks
URL: GET /api/tasks

Query Parameters:

status: Filter by status (pending, in_progress, completed)

per_page: Items per page (default: 10)

Response:

json
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "title": "My Task",
      "description": "Task description",
      "status": "pending",
      "user_id": 1,
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-01T00:00:00.000000Z"
    }
  ],
  "first_page_url": "http://localhost:8000/api/tasks?page=1",
  "from": 1,
  "last_page": 1,
  "last_page_url": "http://localhost:8000/api/tasks?page=1",
  "links": [...],
  "next_page_url": null,
  "path": "http://localhost:8000/api/tasks",
  "per_page": 10,
  "prev_page_url": null,
  "to": 1,
  "total": 1
}
# Create Task
URL: POST /api/tasks

Body:

json
{
  "title": "New Task",
  "description": "Task description",
  "status": "pending"
}
Response: Created task object (201 status)

# Get Single Task
URL: GET /api/tasks/{id}

Response: Single task object

# Update Task
URL: PUT /api/tasks/{id}

Body: Same as create

Response: Updated task object

# Delete Task
URL: DELETE /api/tasks/{id}

Response:

json
{
  "message": "Task deleted"
}

Task Status Values
pending, in_progress, completed

# Testing
Run the test suite to ensure everything is working correctly:

# Run all tests
php artisan test

# Test Cases
Authentication Tests
User registration with valid data

User login with valid credentials

Token generation on successful authentication

# Task Tests
Authenticated user can create tasks

Task listing with pagination

Authorization checks (users can only access their own tasks)

# Project Structure
app/
├── Http/
│   ├── Controllers/
│   │   └── API/
│   │       ├── AuthController.php
│   │       └── TaskController.php
│   └── Requests/
│       ├── LoginRequest.php
│       ├── RegisterRequest.php
│       └── TaskRequest.php
├── Models/
│   ├── User.php
│   └── Task.php
tests/
├── Feature/
│   ├── AuthTest.php
│   └── TaskTest.php
routes/
└── api.php


# Key Components
Controllers: Handle HTTP requests and business logic

Form Requests: Validate incoming requests

Models: Eloquent models for data handling

Tests: Feature tests for API endpoints

Routes: API endpoint definitions

# Security Features
Password hashing with bcrypt

API token authentication with Laravel Sanctum

Authorization middleware for resource protection

CORS configuration for cross-origin requests

Request validation and sanitization

# Error Handling
The API returns appropriate HTTP status codes:

200: Success

201: Created

401: Unauthorized

403: Forbidden

422: Validation error

500: Server error

# Development
Adding New Features
Create migrations for database changes

Update models and relationships

Create form requests for validation

Implement controller methods

Add route definitions

Write comprehensive tests

# Code Standards
Follow PSR-12 coding standards

Write PHPStan-compatible code

Include PHPDoc comments

Maintain test coverage above 80%
