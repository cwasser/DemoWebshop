demo_shop
=========

Small demo shop bundle which will offer an master template with all views and also a RESTful API for
CRUD operation on products.

# What is this good for?

Well the main priority of this package is showing the functionality of the bachelor thesis of me, which is 
in detail a jQuery plugin for enabling application to easy use Single Page Application functionality.
In more detail, this small project have to come with an RESTful API so that the jQuery plugin is able
to use it as a general backend API.

# Whats inside?

The backend will provide a RESTful API for CRUD operations and also a master template with all views.
So this backend will offering the following to the frontend:

- Master template view with all shop related views inside
- RESTful controllers
- a CRUD service to edit products
- Needed entities managed by doctrine services
- Maybe a database as a storage, not yet decided

It also enables javascript at the client side which includes:

- jQuery and jquery.spa.js as dependencies
- several js sources to enable the functionality of jquery.spa.js

# Where to find my SPA plugin for jQuery

For checking out my SPA plugin for jQuery, you can check my profile and take a look at the jquery-spa repository.
You can also simply check the composer.json file to see the dependency.
It is available on https://github.com/cwasser/jquery-spa 

# How to contribute?

Since this is part of my bachelor thesis, there is no chance to really contribute to this project until i finish the first version
and get my graduation.
Please be so kind and also do not report issues or merge request until i will release the first version.

After getting the graduation it will be possible to get accepted merge request and i will have an eye on the reported 
issues. That means everyone is then free to contribute to this project.

# Directory index
Description of the directory folders. 
## app/
Application configuration and also standard Symfony configuration

## src/DemoShopBundle/

Source folder for the demo_shop bundle, which includes the whole backend.
In detail the sub folders are
- Contoller/ -> RESTful controllers
- Tests/ -> application tests
- Services/ -> all bundle related services
- Entity/ -> the main data entities like Product
- Resources/ -> all resources like service and route configuration and also the views

## src-js/

All javascript sources and libraries.
For detailed information see the src-js/README.md.

## vendor/

All dependencies and vendor libraries, such as Symfony, doctrine and so on.

## web/

All public files accessible via the web. This includes compiled and minimized js sources as
well as the rendered templates.
