var gulp = require('gulp'),
    gutil = require('gulp-util'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    jshint = require('gulp-jshint'),
    sourcemaps = require('gulp-sourcemaps'),
    del = require('del'),
    map = require('map-stream'),
    gulpif = require('gulp-if');

var DEST = './web/js/',
    PATHS = {
        scripts: [
            './app/Resources/public/js/**/*.js',
            './src/DemoShopBundle/Resources/js/**/*.js'
        ],
        script_libs: [
            './node_modules/jquery/dist/jquery.min.js',
            './node_modules/jquery.spa/dist/jquery.spa.min.js'
        ]
    },
    ENV = process.env.GULP_ENV;

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

gulp.task('build', function(){
    return gulp.src(PATHS.scripts.concat(PATHS.script_libs))
        .pipe(concat('prod.js'))
        .pipe(sourcemaps.init())
        .pipe(gulpif(ENV === 'prod', uglify()))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(DEST));
});

gulp.task('jshint',function(){
    return gulp.src(PATHS.scripts)
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
    gulp.watch(PATHS.scripts, function(event){
        console.log(logTime() + 'File ' + event.path + ' was ' + event.type + ', checking with jshint...');
        return gulp.src(PATHS.scripts)
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
