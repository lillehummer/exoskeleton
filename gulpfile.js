// Include gulp
var gulp = require('gulp'); 

// Include Our Plugins
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var minifycss = require('gulp-minify-css');
var rename = require('gulp-rename');
var filter = require('gulp-filter');
var mainBowerFiles = require('main-bower-files');
var browserSync = require('browser-sync');
var gulpUtil = require('gulp-util');
var imagemin = require('gulp-imagemin');
var pngquant = require('imagemin-pngquant');
var postcss = require('gulp-postcss');
var autoprefixer = require('autoprefixer-core');
var mqpacker = require('css-mqpacker');
var csswring = require('csswring');
var plumber = require('gulp-plumber');

gulp.task('browser-sync', function() {
    var files = [
    './css/style.css',
    './*.php',
    './**/*.php'
    ];

    browserSync.init(files, {
        proxy: "lillehummer.local/",
        notify: false
    });
});

gulp.task('images', function () {
    return gulp.src('img/src/*')
        .pipe(plumber())
        .pipe(imagemin({
            optimizationLevel: 3,
            interlaced: true,
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngquant()]
        }))
        .pipe(gulp.dest('img/'));
});

gulp.task('sass', function () {
    var processors = [
        autoprefixer({browsers: ['last 2 version', 'ie 9']}),
        mqpacker,
        csswring
    ];
    return gulp.src('./scss/*.scss')
        .pipe(plumber())
        .pipe(sass({ style: 'expanded' }))
        .pipe(postcss(processors))
        .pipe(gulp.dest('./css'))
        .pipe(browserSync.reload({stream:true}));
});

// Concatenate & Minify JS
gulp.task('scripts', function() {
    var jsFiles = ['./js/src/*.js'];
    gulp.src(mainBowerFiles().concat(jsFiles))
        .pipe(plumber())
        .pipe(filter('*.js'))
        .pipe(concat('app.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./js/'))
        .on('change', browserSync.reload);
 });

// Default Task
gulp.task('default', ['browser-sync', 'sass', 'scripts'], function(){

    // Watch For Changes To Our JS
    gulp.watch('./js/src/*.js', function(){
        gulp.run('scripts');
    });

    // Watch For Changes To Our SCSS
    gulp.watch(['./scss/*.scss', './scss/**/*.scss'], function(){
        gulp.run('sass');
    });
});