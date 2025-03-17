# Fotexnet

## Overview
This is a basic Laravel-based application called Fotexnet created by Felföldi Szabolcs.

The applications core function is to handle/manage movies and their screenings.

## Installation
1. Clone the repository.

`git clone git@github.com:szabtsi/fotexnet.git`

2. Install PHP dependencies

`composer install`

3. Create an environment configuration file based on the example file.

`cp .env.example .env`

4. Generate an unique application key.

`php artisan key:generate`

5. Run migrations and optionally populate is with basic data.

`php artisan migrate --seed`

## Usage
Serve the application using "php artisan serve". The application is available in dockerized environment, using Laravel Sail.
