// Include gulp
var gulp = require('gulp'); 

// Include Our Plugins
var jshint = require('gulp-jshint');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var autoprefixer = require('gulp-autoprefixer');
var minifycss = require('gulp-minify-css');
var rename = require('gulp-rename');
var filter = require('gulp-filter');
var mainBowerFiles = require('main-bower-files');

// Lint Task
gulp.task('lint', function() {
    gulp.src('./js/*.js')
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
});

// Compile Our Sass
gulp.task('sass', function() {
    gulp.src('./scss/*.scss')
        .pipe(sass({ style: 'expanded' }))
        .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1'))
        .pipe(gulp.dest('./css'))
        .pipe(minifycss())
        .pipe(gulp.dest('css'));;
});

// Concatenate & Minify JS
gulp.task('scripts', function() {
    var jsFiles = ['./js/src/**/*.js', './js/src/*.js'];
    gulp.src(mainBowerFiles().concat(jsFiles))
        .pipe(filter('*.js'))
        .pipe(concat('app.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./js/'));
 });

// Default Task
gulp.task('default', function(){
    gulp.run('sass', 'scripts');

    // Watch For Changes To Our JS
    gulp.watch('./js/*.js', function(){
        gulp.run('scripts');
    });

    // Watch For Changes To Our SCSS
    gulp.watch(['./scss/*.scss', './scss/**/*.scsss'], function(){
        gulp.run('sass');
    });
});