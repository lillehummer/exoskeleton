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
var pixrem = require('pixrem');
var plumber = require('gulp-plumber');
var sourcemaps = require('gulp-sourcemaps');
var RevAll = require('gulp-rev-all');
var revDel = require('rev-del');
var runSequence = require('run-sequence');
var cssnext = require('cssnext');
var precss = require('precss');
var svgfallback = require('postcss-svg-fallback');
var doiuse = require('doiuse');
var at2x = require('postcss-at2x');
var options = require('./src/build.json');

//
// DEFAULT
//

    // Default Task
    gulp.task('default', ['browser-sync', 'css', 'js'], function(){

        gulp.watch('src/js/*.js', ['js']).on('change', browserSync.reload);
        gulp.watch(['src/css/*.scss', 'src/css/**/*.scss'], ['css']);

    });

//
// BROWSER SYNC
//

    gulp.task('browser-sync', function() {

        var files = [
        './css/style.css',
        './*.php',
        './**/*.php',
        './**/**/*.php'
        ];

        browserSync.init(files, {
            proxy: options.proxy,
            notify: false
        });

    });

//
// OPTIMIZE IMAGES
//

    gulp.task('images', function () {

        return gulp.src('src/img/*')
            .pipe(plumber(function(error) {
                gulpUtil.log(gulpUtil.colors.red(error));
                this.emit('end');
            }))
            .pipe(imagemin({
                optimizationLevel: 3,
                interlaced: true,
                progressive: true,
                svgoPlugins: [{removeViewBox: false}],
                use: [pngquant()]
            }))
            .pipe(gulp.dest('img'));

    });

//
// BUILD CSS
//

    gulp.task('css', function(callback) {

        var processors = [
            precss,
            cssnext,
            autoprefixer({browsers: ['last 2 version', 'ie 9']}),
            mqpacker,
            pixrem,
            csswring
        ];

        return gulp.src(options.cssFiles)
            .pipe(plumber(function(error) {
                gulpUtil.log(gulpUtil.colors.red(error));
                this.emit('end');
            }))
            .pipe(sourcemaps.init())
            .pipe(sass({ style: 'compressed' }))
            .pipe(postcss(processors))
            .pipe(gulp.dest('src/rev/css'))
            .pipe(sourcemaps.write())
            .pipe(gulp.dest('css'))
            .pipe(browserSync.reload({stream:true}));

    });

//
// BUILD JAVASCRIPT
//

    gulp.task('js', function(callback) {

        return gulp.src(mainBowerFiles().concat(options.jsFiles))
            .pipe(plumber())
            .pipe(filter('*.js'))
            .pipe(sourcemaps.init())
            .pipe(concat('app.js'))
            .pipe(sourcemaps.write())
            .pipe(gulp.dest('js'))
            .pipe(uglify())
            .pipe(gulp.dest('src/rev/js'));

    });

//
// CREATE REVISIONS
//

    gulp.task('rev', function(callback) {

        var revOptions = {
            dontRenameFile: ['functions.php']
        };

        var revAll = new RevAll(revOptions);

        return gulp.src(['src/rev/**'])
                .pipe(plumber())
                .pipe(revAll.revision())
                .pipe(gulp.dest('./'))
                .pipe(revAll.manifestFile())
                .pipe(revDel('src/rev-manifest.json'))
                .pipe(gulp.dest('src'));

    });

//
// BUILD
//

    gulp.task('build', function(callback) {

        runSequence(['images', 'css', 'js'], 'rev', callback);

    });
