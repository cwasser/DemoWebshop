/**
 * Created by cwasser on 26.04.16.
 */
require('../../../../../node_modules/jquery.spa/src/spa.js');

module.exports = (function($){
    'use strict';
    //------------------------------------------ VARIABLES ---------------------
    var book,

        CartView = require('./cartView'),

        getBookCallback, updateBookCallback, deleteBookCallback,

        addBookRoute, renderBookForOverview, renderBookDetail;

    //------------------------------------------ CALLBACKS ---------------------
    deleteBookCallback = function(data, jqXHR, textStatus){
        $.spa.navigate('/books');
    };

    updateBookCallback = function(data, jqXHR, textStatus){
        $.spa.navigate('/books');
    };

    getBookCallback = function(data, jqXHR, textStatus){
        renderBookDetail(data);
    };

    //------------------------------------------ SPA ---------------------------
    addBookRoute = function(book){
        var bookRoute = '/books/' + book.id;
        if (! $.spa.hasRoute(bookRoute, 'GET')){
            $.spa.addRoute(
                bookRoute,
                getBookCallback,
                {
                    isResource : true,
                    httpMethod : 'GET',
                    shouldTriggerStateUpdate : true,
                    useHistoryStateFallback : true
                }
            )
        }
        if (!$.spa.hasRoute(bookRoute, 'PUT')){
            $.spa.addRoute(
                bookRoute,
                updateBookCallback,
                {
                    isResource : true,
                    httpMethod : 'PUT',
                    shouldTriggerStateUpdate : false,
                    useHistoryStateFallback : false
                }
            );
        }
        if (!$.spa.hasRoute(bookRoute, 'DELETE')){
            $.spa.addRoute(
                bookRoute,
                deleteBookCallback,
                {
                    isResource : true,
                    httpMethod : 'DELETE',
                    shouldTriggerStateUpdate : false,
                    useHistoryStateFallback : false
                }
            )
        }
    };
    //------------------------------------------ RENDER ------------------------
    renderBookDetail = function(book) {
        var $bookDetailView = $('<div id="' + book.id + '" class="book-details"></div>'),
            $container = $('#overview');

        $bookDetailView.append($('<div class="book-details__menu">' +
                '<input type="button" value="Back" class="book-details__button details__back"/>' +
                '<p class="book-details__title">' + book.title + '</p>' +
            '</div>'));

        $bookDetailView.append($('<div class="book-details__meta">' +
                '<div class="book-details__cover">book cover</div>' +
                '<div class="book-details__price">' +
                    book.price + '€<br/><input type="button" value="add to cart" class="book-details__button details_addToCart"/>' +
                '</div>' +
            '</div>'));

        if (typeof book.description !== 'undefined'){
            $bookDetailView.append($('<div class="book-details__description">' + book.description + '</div>'));
        }

        $bookDetailView.append($('<div class="book-details__information">' +
                '<div class="book-details__information__key"></div>' +
                '<div class="book-details__information__value"></div>' +
            '</div>'));

        if (typeof book.author !== 'undefined'){
            $bookDetailView.find('.book-details__information__key').append($('<b>Author:</b><br/>'));
            $bookDetailView.find('.book-details__information__value').append(book.author+'<br/>');
        }

        if (typeof book.publisher !== 'undefined'){
            $bookDetailView.find('.book-details__information__key').append($('<b>Publisher:</b><br/>'));
            $bookDetailView.find('.book-details__information__value').append(book.publisher+'<br/>');
        }

        if (typeof book.isbn !== 'undefined'){
            $bookDetailView.find('.book-details__information__key').append($('<b>ISBN:</b><br/>'));
            $bookDetailView.find('.book-details__information__value').append(book.isbn+'<br/>');
        }

        if (typeof book.language !== 'undefined'){
            $bookDetailView.find('.book-details__information__key').append($('<b>Language:</b><br/>'));
            $bookDetailView.find('.book-details__information__value').append(book.language+'<br/>');
        }

        $bookDetailView.on('click', '.details_addToCart', {book: book}, function ( event ){
            CartView.addBook(event.data.book);
        });

        $bookDetailView.on('click', '.details__back', function (event ){
            $.spa.navigate('/books');
        });

        $container.children().remove();
        $container.append($bookDetailView);
    };

    renderBookForOverview = function(bookData){
        var $book = $('<p class="book"></p>');

        $book.append('<div class="book__menu">' +
                '<input type="button" class="book__button book__details" style="margin-right: 80px;" value="details">' +
                '<input type="button" class="book__button book__addToCart" value="Add to cart">' +
            '</div>');

        if ( typeof bookData.id !== 'undefined'){
            $book.attr('id', bookData.id);
        }
        if ( typeof bookData.title !== 'undefined'){
            $book.append('<p class="book__title">' + bookData.title + '</p>');
        }
        $book.append('<div class="book__cover">Book cover</div>');
        if ( typeof bookData.description !== 'undefined'){
            $book.append('<p class="book__desc">'+ bookData.description + '</p>');
        }
        if ( typeof bookData.price !== 'undefined'){
            $book.append('<b class="book__price">' + bookData.price + '€</p>');
        }

        $book.on('click', '.book__details', {route : '/books/'+bookData.id }, function( event ) {
            $.spa.navigate(event.data.route);
        });

        $book.on('click', '.book__addToCart', {book: bookData}, function ( event ){
            CartView.addBook(event.data.book);
        });

        return $book;
    };
    //------------------------------------------ LISTENERS ---------------------

    return {
        addBookRoute : addBookRoute,
        renderBookForOverview : renderBookForOverview
    };
}(window.jQuery));
