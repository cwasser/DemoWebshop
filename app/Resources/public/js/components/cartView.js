/**
 * Created by cwasser on 26.04.16.
 */
require('../../../../../node_modules/jquery.spa/src/spa.js');

module.exports = (function($){
    'use strict';
    //------------------------------------------ VARIABLES ---------------------
    var cartRoute = '/cart',
        el = '.cartBooks',
        books = {},

        init,
        addBook, removeBook, getBook,
        onCartBookRemove, onOrderClick,
        orderBooksCallback,
        render;
    //------------------------------------------ SPA ---------------------------
    orderBooksCallback = function(data, jqXHR, textStatus){
        books = [];
        render();

        alert(data.message);

        $.spa.navigate('/books');
    };
    //------------------------------------------ RENDER ------------------------
    render = function(){
        var totalPrice = 0,
            $orderButton = $('<input type="button" value="Order!" class="cartOrderButton"/>'),
            $totalPriceDiv = $('<p class="cartTotalPrice">Total: </p>');
        $(el).children().remove();

        $.each(books, function(id, bookObj){
            if (typeof bookObj !== 'undefined'){
                var $book = $('<div class="cartBook">' +
                        '<div class="cartBook__count">' + bookObj.count + ' x </div>' +
                        '<div class="cartBook__desc">' +
                            '<input type="button" value="x" class="cartBook__button__delete"/>' +
                            '<p class="cartBook__desc__title">'+ bookObj.book.title + '</p>' +
                            '<p class="cartBook__desc__desc">'+bookObj.book.description + '</p>' +
                        '</div>' +
                        '<div class="cartBook__price">' + bookObj.book.price + '</div>' +
                    '</div>');

                totalPrice += (bookObj.count * bookObj.book.price);

                $book.on('click','.cartBook__button__delete', {id : id}, onCartBookRemove );

                $(el).append($book);
            }
        });

        $orderButton.on('click', onOrderClick);
        $totalPriceDiv.append(totalPrice);
        $(el).append($totalPriceDiv);
        $(el).append($orderButton);
    };
    //------------------------------------------ LISTENERS ---------------------
    onCartBookRemove = function ( event ){
        var id = event.data.id,
            bookObj;
        bookObj = getBook(id);
        if ( !$.isEmptyObject(bookObj)){
            removeBook(bookObj);
        }
    };

    onOrderClick = function ( event ){
        var ids = [];
        $.each(books, function(index, val){
            if (typeof val !== 'undefined'){
                ids.push(val.book.id);
            }
        });

        //grey overlay and loading screen for 4 seconds here
        $('body').append($('<div class="cartBook__overlay">Sending data ...</div>'));

        setTimeout(function(){
            $.spa.createResource(cartRoute, {book_ids : ids });
            $('body').find('.cartBook__overlay').remove();
        },5000);
    };
    //------------------------------------------ FUNCTIONS ---------------------
    addBook = function(book){
        if ( typeof book === 'object'){
            if (books.hasOwnProperty(book.id)){
                books[book.id].count++;
            }else{
                books[book.id] = {
                    count : 1,
                    book : book
                }
            }
        }
        render();
    };

    getBook = function(bookId){
        var book = books[bookId];
        if (typeof book !== 'undefined'){
            return book;
        }
        return {};
    };

    removeBook = function(bookObj){
        if (books.hasOwnProperty(bookObj.book.id)){
            if(books[bookObj.book.id].count > 1 ){
                books[bookObj.book.id].count--;
            }else{
                delete books[bookObj.book.id];
            }
        }
        render();
    };
    //------------------------------------------ INIT --------------------------
    init = function(){
        // add only POST route
        $.spa.addRoute(
            cartRoute,
            orderBooksCallback,
            {
                isResource : true,
                httpMethod : 'POST',
                shouldTriggerStateUpdate : false,
                useHistoryStateFallback : false
            }
        )
    };

    return {
        init : init,
        addBook : addBook
    };
}(window.jQuery));
