
## Welcome to Dog Gone It

Dog Gone It is software to aid in everyday dog daycare services including boarding and grooming
com
## How to use this product



## Requirements

- Docker Desktop
- PHP version 8 or higher

## Installation

-  After cloning the project, you will need to open your php.ini file and ensure that these two lines
have the semicolon removed: extension=fileinfo and extension=zip
- Once you save the file, run composer update in your terminal.
- Run `docker compose -build`. This will take a few minutes the first time.
- After it builds, run `docker compose up -d`

## Seeding the db

- Once the project is up, you will want to connect to your database and run `php artisan migrate --seed`





