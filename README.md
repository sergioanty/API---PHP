API---PHP

Тестовое задание

Простое REST API для управления списком задач, реализованное на чистом PHP и MySQL

Возможности

Создание задачи (POST /tasks)

Просмотр всех задач (GET /tasks)

Просмотр одной задачи (GET /tasks/id)

Обновление задачи (PUT /tasks/id)

Удаление задачи (DELETE /tasks/id)

Установка и запуск

Склонируйте репозиторий в папку "htdocs" (XAMPP)

git clone

-/-/-/-/-/-

Создайте базу данных в MySQL через phpMyAdmin

CREATE DATABASE api;
USE api;

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('pending','in_progress','done') DEFAULT 'pending'
);

-/-/-/-/-/-/-

Настройте подключение к БД в файле db.php

$host = "localhost";   // адрес сервера
$user = "root";        // XAMPP
$pass = "";            // пароль
$db   = "api";    // название базы данных

-/-/-/-/-/-/-

API будет доступно по адресу
http://localhost/api/index.php/tasks

-/-/-/-/-/-/-

Создание задачи (POST)

POST /tasks

{
  "title": "заголовок",
  "description": "API на PHP",
  "status": "pending"
}

--------------------------

Список всех задач: GET /tasks

возвращает все задачи в формате JSON

--------------------------

Список одной задачи по id: GET /tasks/1

возвращает одну задачу с id = 1

--------------------------

Обновление задачи: PUT /tasks/1

{
  "title": "изменить заголовок",
  "description": "новое описание",
  "status": "done"
}

-------------------------

Удаление задачи: DELETE /tasks/1

////////////////////////////////////////////////////////

я тестировал через Postman
