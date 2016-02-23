tuanht_coding_challenge
=======================

# Install

## MySQL

Mac OS X via Homebrew:
- `brew install mysql`
- `mysql.server start`

## Composer

Mac OS X via Homebrew:
- `brew install homebrew/php/composer`

## Checkout project

- `git clone git@github.com:tuanht/symfony_coding_challenge.git`
- `cd symfony_coding_challenge`
- `composer install`

# Running

- `php app/console server:run`
- Using postman to make request
- `POST http://localhost:8000/api/offers?date=2016-02-29`
(optional HTTP Accept header: `application/json` or `text/html`)
- `DELETE http://localhost:8000/api/offers/1`

# Testing
- `bin/phpunit -c app`