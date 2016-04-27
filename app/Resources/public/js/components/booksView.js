/**
 * Created by cwasser on 26.04.16.
 */
require('../../../../../node_modules/jquery.spa/src/spa.js');

module.exports = (function($){
    'use strict';
    //------------------------------------------ VARIABLES ---------------------
    var booksRoute = '/books',
        books = [],

        hasStarted = false, start,

        BookView = require('./bookView'),

        booksCallback, createBookCallback, newBookCallback,
        renderBook, clearOldBooksConfig, init;
    //------------------------------------------ CALLBACKS ---------------------
    createBookCallback = function(data, jqXHR, textStatus){
        // After creation go back to the overview
        $.spa.navigate(booksRoute);
    };

    newBookCallback = function(data, jqXHR, textStatus){
        $.spa.navigate(booksRoute);
    };

    booksCallback = function(data, jqXHR, textStatus){
        var $container = $('#overview'),
            $booksView = $('<div id="books" class="books"></div>'),
            $book;

        clearOldBooksConfig();

        if ( !$.isEmptyObject(data)){
            if ($.isArray(data)){
                for(var i = 0; i < data.length; i++){
                    BookView.addBookRoute(data[i]);
                    books.push(data[i]);
                    $booksView.append(renderBook(data[i]));
                }
            } else if (typeof data === 'object'){
                BookView.addBookRoute(data);
                books.push(data);
                $booksView.append(renderBook(data));
            }
            $container.children().remove();
            $container.append($booksView);
        }

        //Start spa plugin only after the newest routes are fetched
        if(!hasStarted){
            start();
            $.spa.removeRoute(booksRoute,'GET');
            $.spa.addRoute(
                booksRoute,
                booksCallback,
                {
                    isResource : true,
                    httpMethod : 'GET',
                    shouldTriggerStateUpdate : true,
                    useHistoryStateFallback : true
                }
            )
        }

    };
    //------------------------------------------ SPA ---------------------------
    clearOldBooksConfig = function(){
        for(var i=0; i < books.length; i++) {
            $.spa.removeRoute(booksRoute + '/' + books[i].id, 'GET');
            $.spa.removeRoute(booksRoute + '/' + books[i].id, 'PUT');
            $.spa.removeRoute(booksRoute + '/' + books[i].id, 'DELETE');
        }
        books = [];
    };

    start = function(){
        hasStarted = true;
        $.spa.run();
    };
    //------------------------------------------ RENDER ------------------------
    renderBook = function ( book ) {
        return BookView.renderBookForOverview( book );
    };
    //------------------------------------------ LISTENERS ---------------------

    //------------------------------------------ INIT --------------------------
    init = function(){

        // add POST route
        $.spa.addRoute(
            booksRoute,
            createBookCallback,
            {
                isResource : true,
                httpMethod : 'POST',
                shouldTriggerStateUpdate : false,
                useHistoryStateFallback : false
            }
        );

        $.spa.addRoute(
            booksRoute,
            booksCallback,
            {
                isResource : true,
                httpMethod : 'GET',
                shouldTriggerStateUpdate : false,
                useHistoryStateFallback : false
            }
        );
    };

    return {
        init : init
    };
}(window.jQuery));
