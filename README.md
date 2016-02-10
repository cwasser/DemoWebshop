demo_shop
=========

Small demo shop bundle with Symfony 2.8 and jQuery, which provides a RESTful shop API and a Single Page Application later on.

# What is this good for?

Well the main priority of this project is showing the functionality of my bachelor thesis, which is 
in detail a jQuery plugin which provides simple SPA functionality, so that its easy to SPAlify your application.

This project shows the usage of the jquery.spa.js plugin with providing an RESTful API and delivering all templates in 
a single template, so all resources are loaded during the first request to this application.

# Whats inside?

The backend will provide a RESTful API for CRUD operations and also a templates which contains already all needed HTML.
So this backend will offering the following to the frontend:

- a template with all needed HTML
- RESTful controllers
- a CRUD service to edit products
- Needed entities managed by doctrine services
- JS files which will use the functionality of jquery.spa.js
- Maybe a database as a storage, not yet decided

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

# How to install
First clone this repository. After doing that simply run
```
composer install && npm install
```

# Directory index
Description of the directory folders. 

## app/
Application related configuration

## app/Resources/public/js/
Javascript source files for the demo web shop

## app/Resources/public/css/
CSS sources for the demo web shop

## src/DemoShopBundle/
Source folder for the demo_shop bundle, which contains the API and Domain Logic.
In detail the sub folders contain:
- Controller/ -> RESTful controller + IndexController
- Tests/ -> application related unit tests
- Services/ -> all bundle related services
- Entity/ -> DTO's and Entities
- Resources/ -> bundle specific configuration (e.g. services and routes)

## vendor/
All vendor libraries and dependencies

## node_modules/
All javascript third party libraries which are loaded by NPM (package.json). 
jQuery and also jquery.spa.js live in there.

## web/
All public files accessible via the web. This includes compiled and minimized js sources as
well as the rendered templates.
