/**
 * Created by cwasser on 13.04.16.
 */
    'use strict';
window.jQuery = require('jquery');
window.$ = window.jQuery;
require('../../../../node_modules/jquery.spa/src/spa.js');


$(function(){
    'use strict';
    // ------------ VARIABLES ----------------------------
    var rootCallback,

        booksRoute = '/books', rootRoute = '/',

        BooksView = require('./components/booksView'),
        CartView = require('./components/cartView');

    // ------------ CONFIGURATION ------------------------
    $.spa.configModule({
        historyConfig : {
            useHistoryApi : true
        },
        dataConfig : {
            serverUrl : 'http://localhost:8000/app_dev.php/api/v1'
        },
        routerConfig : {}
    });

    rootCallback = function(){
        $.spa.navigate(booksRoute);
    };

    $.spa.addRoute(
        rootRoute,
        rootCallback,
        {
            isResource : false,
            httpMethod : 'GET'
        }
    );


    BooksView.init();
    CartView.init();
    $.spa.getResource(booksRoute);

    // ------------ FUNCTIONS ----------------------------

});
