// Include gulp
var gulp = require('gulp');

// Include Our Plugins
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var filter = require('gulp-filter');
var mainBowerFiles = require('main-bower-files');
var browserSync = require('browser-sync');
var gulpUtil = require('gulp-util');
var imagemin = require('gulp-imagemin');
var pngquant = require('imagemin-pngquant');
var postcss = require('gulp-postcss');
var autoprefixer = require('autoprefixer');
var changed = require('gulp-changed');
var mqpacker = require('css-mqpacker');
var plumber = require('gulp-plumber');
var sourcemaps = require('gulp-sourcemaps');
var RevAll = require('gulp-rev-all');
var revDel = require('rev-del');
var runSequence = require('run-sequence');
var notify = require('gulp-notify');
var options = require('./src/build.json');

var onError = function(err) {
    notify.onError({
                title: "Error",
                message: err.message,
                sound: false
            })(err);

    gulpUtil.log(gulpUtil.colors.red(err));
    this.emit('end');
};

//
// DEFAULT
//

    gulp.task('default', ['browser-sync', 'css', 'js'], function(){

        gulp.watch('src/js/*.js', ['watch-js']).on('change', browserSync.reload);
        gulp.watch('src/rev/functions.php', ['rev']);
        gulp.watch(['src/css/*.scss', 'src/css/**/*.scss'], ['watch-css']);
        gulp.watch(['src/img/*'], ['images']);

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

        var notification = {
            title: 'Task',
            message: 'images finished',
            onLast: true
        };

        return gulp.src('src/img/*')
            .pipe(plumber({errorHandler: onError}))
            .pipe(changed('img'))
            .pipe(imagemin({
                optimizationLevel: 3,
                interlaced: true,
                progressive: true,
                svgoPlugins: [{removeViewBox: false}],
                use: [pngquant()]
            }))
            .pipe(gulp.dest('img'))
            .pipe(notify(notification));

    });

//
// BUILD CSS
//

    gulp.task('css', function(callback) {

        var notification = {
            title: 'Task',
            message: 'css finished',
            onLast: true
        };

        var processors = [
            autoprefixer({browsers: ['last 2 version', 'ie 9']}),
            mqpacker
        ];

        return gulp.src('src/css/*.scss')
            .pipe(plumber({errorHandler: onError}))
            .pipe(sourcemaps.init())
            .pipe(sass({ outputStyle: 'compressed' }))
            .pipe(postcss(processors))
            .pipe(gulp.dest('src/rev/css'))
            .pipe(sourcemaps.write())
            .pipe(gulp.dest('css'))
            .pipe(browserSync.reload({stream:true}))
            .pipe(notify(notification));

    });

    gulp.task('watch-css', function(callback) {

        runSequence('css', 'rev', callback);

    });

//
// BUILD JAVASCRIPT
//

    gulp.task('js', function(callback) {

        var notification = {
            title: 'Task',
            message: 'js finished',
            onLast: true
        };

        var jsFilter = filter('**/*.js', {restore: true});

        return gulp.src(mainBowerFiles().concat(options.jsFiles))
            .pipe(plumber({errorHandler: onError}))
            .pipe(jsFilter)
            .pipe(sourcemaps.init())
            .pipe(concat('app.js'))
            .pipe(sourcemaps.write())
            .pipe(gulp.dest('js'))
            .pipe(uglify())
            .pipe(gulp.dest('src/rev/js'))
            .pipe(notify(notification));

    });

    gulp.task('watch-js', function(callback) {

        runSequence('js', 'rev', callback);

    });

//
// CREATE REVISIONS
//

    gulp.task('rev', function(callback) {

        var notification = {
            title: 'Task',
            message: 'rev finished',
            onLast: true
        };

        var revOptions = {
            dontRenameFile: ['functions.php']
        };

        var revAll = new RevAll(revOptions);

        return gulp.src(['src/rev/**'])
                .pipe(plumber({errorHandler: onError}))
                .pipe(revAll.revision())
                .pipe(gulp.dest('./'))
                .pipe(revAll.manifestFile())
                .pipe(revDel('src/rev-manifest.json'))
                .pipe(gulp.dest('src'))
                .pipe(notify(notification));

    });

//
// BUILD
//

    gulp.task('build', function(callback) {

        runSequence(['images', 'css', 'js'], 'rev', callback);

    });
