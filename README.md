demo_shop
=========

Small demo shop bundle with

- Symfony 2.8
- FOS/RestBundle
- Nelmio/ApiDocBundle
- jQuery
- jQuery SPA plugin

which provides a RESTful book shop API and a Single Page Application later on.
The demo shop is currently build for providing REST operations for an book entity.

# What is this good for?

Well the main priority of this project is showing the functionality of my bachelor thesis, which is 
in detail a jQuery plugin which provides simple SPA functionality, so that its easy to SPAlify your application.

This project shows the usage of the jquery.spa.js plugin with providing an RESTful API and delivering all templates in 
a single template, so all resources are loaded during the first request to this application.

# Whats inside?

The backend will provide a RESTful API for CRUD operations for books.
So this backend will offering the following to the frontend:

- RESTful controller
- a CRUD service for books
- Needed entities managed by doctrine services

This project rely on the following dependencies for the client side:

- jQuery
- jquery.spa.js

# Where to find the SPA plugin for jQuery

For checking out my SPA plugin for jQuery, you can check my profile and take a look at the jquery-spa repository.
It is available on https://github.com/cwasser/jquery-spa 

# How to contribute?

This is the demonstration part of my bachelor thesis, so before getting my graduation I will not take a look on
reported issues or Pull/Merge requests.
After getting my graduation I will update the README as well as the documentation. Then I will have an eye on the
reported issues and also on Pull/Merge requests. Then also everyone who wants to contribute should feel free to do it.

# Installation instructions
First clone this repository. After doing that simply run
```
composer install && npm install
```

Also you have to configure the app/config/parameters.yml to setup your database connection.
After editing the config, you might run
```
app/console doctrine:database:create
app/console doctrine:schema:validate
app/console doctrine:schema:update --force
```

For building the client side assets (JS, templates and CSS), run the following:
```
npm install
gulp
```

# Directory index
Description of the directory folders.
Checkout the project dependencies in ``package.json`` and in ``composer.json``

## app/
Application related configuration

## app/Resources/public/js/
Javascript source files for the demo web shop

## app/Resources/public/css/
CSS sources for the demo web shop

## src/Cwasser/BookShopBundle/
Source folder for the demo_shop bundle, which contains the API and Domain Logic.
In detail the sub folders contain:
- Controller/ -> RESTful controller + other Controller
- DependencyInjection/ -> DIC related stuff
- Resources/ -> bundle specific configuration (e.g. services and routes)
- V1/ -> all domain logic for version 1 of the book API
-- V1/Entity/ -> Doctrine managed entities for V1 and also the interfaces
-- V1/Form/ -> Form types for V1 entities
-- V1/Repository/ -> Doctrine repositories for v1's doctrine managed entities
-- V1/Service/ -> All services for V1
-- V1/Tests/ -> All units test for V1

## vendor/
All vendor libraries and dependencies

## node_modules/
All javascript third party libraries which are loaded by NPM (package.json). 
jQuery and also jquery.spa.js live in there.

## web/
All public files accessible via the web. This includes compiled and minimized js sources as
well as the rendered templates.
