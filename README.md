# UFO API

The UFO API is a simple REST API that allows you report and investigate UFO sightings.

## Features

-   Authentication
-   Search reports and dossiers
-   Manage reports and dossiers

## Requirements

-   PHP 8.1
-   Composer

## Installation

```bash
$ git clone https://github.com/Golveira/ufo-api.git
$ cd ufo-api
$ composer install
$ cp .env.example .env
$ php artisan key:generate
$ php artisan migrate
$ php artisan storage:link
$ php artisan serve
```

## Usage
