// Imports for building

    // Gulp
var gulp = require('gulp'),
    // Gulp utilities
    gutil = require('gulp-util'),
    rename = require('gulp-rename'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    sourcemaps = require('gulp-sourcemaps'),
    jshint = require('gulp-jshint'),
    tap = require('gulp-tap'),
    // Additional plugins
    // delete something
    del = require('del'),
    map = require('map-stream'),
    // making AMD modules ready for the browser
    browserify = require('browserify'),
    // vinyl source stream to use the stream of non gulp plugins
    source = require('vinyl-source-stream'),
    // reactify (browserify advanced)
    reactify = require('reactify');

var DEST = './web/js/',
    SRC_FILES = ['./app/Resources/public/js/index.js'],
    SRC_FILES_ALL = [
        './app/Resources/public/js/**/*.js',
        './src/Cwasser/BookShopBundle/Resources/public/js/**/*.js',
        './node_modules/jquery/dist/jquery.min.js'
    ],
    BROWSERIFY_OPS = {
        entries : SRC_FILES,
        debug : true
    },
    TARGET_FILENAME = 'prod.js';

var logTime = function(){
    var date = new Date(),
        hours = date.getHours(),
        minutes = '0' + date.getMinutes(),
        seconds = '0' + date.getSeconds();

    return '[' + hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2) + ']: ';
};

gulp.task('default',['clean','jshint','build'], function(){
    return gutil.log('clean and build successfully finished');
});

gulp.task('browserify', function(){
    var bundler = browserify(BROWSERIFY_OPS),
        stream;
    bundler.transform(reactify);
    stream = bundler.bundle();

    return stream.on('error', gutil.log.bind(gutil, logTime() + ' Browserify Error'))
        .pipe(source(TARGET_FILENAME))
        .pipe(gulp.dest(DEST));
});

gulp.task('build', ['browserify'], function(){
    return gulp.src([DEST + TARGET_FILENAME])
        .pipe(gulp.dest(DEST))
        .pipe(sourcemaps.init({loadMaps : true }))
        .pipe(uglify())
        .pipe(rename({ extname : '.min.js'}))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(DEST));
});

gulp.task('jshint',function(){
    return gulp.src(SRC_FILES_ALL)
        .pipe(jshint())
        .pipe(jshint.reporter('jshint-stylish'))
        .pipe(map(function exitOnJsHintFail(file, cb){
            if(!file.jshint.success) {
                console.error(logTime() + 'Error! jshint check failed');
                process.exit();
            }
        }));
});

gulp.task('watch', function(){
    console.log(logTime() + 'Start watching JS sources and check them with jshint');
    gulp.watch(SRC_FILES_ALL, function(event){
        console.log(logTime() + 'File ' + event.path + ' was ' + event.type + ', checking with jshint...');
        return gulp.src(SRC_FILES_ALL)
            .pipe(jshint())
            .pipe(jshint.reporter('jshint-stylish'))
            .pipe(map(function showJsHintState(file, cb){
                if(!file.jshint.success) {
                    console.log(logTime() + 'Some files contain errors');
                } else {
                    console.log(logTime() + 'Everything looks good');
                }
            }));
    });
});

gulp.task('clean', function(){
    return del('./web/js/*');
});
