// Include Gulp
var gulp = require('gulp');

// Include plugins
var gulpUtil = require('gulp-util');
var imagemin = require('gulp-imagemin');
var changed = require('gulp-changed');
var pngquant = require('imagemin-pngquant');
var kraken = require('gulp-kraken');
var plumber = require('gulp-plumber');
var notify = require('gulp-notify');
var exec = require('child_process').exec;

// Error handler
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
            .pipe(kraken({
	            key: '15385d7f05c98978554480e10ef224bf',
	            secret: '0c1ee8098cd1e4884acbd671c57a73f04eca9147',
	            lossy: true,
	            concurrency: 6
	        }))
            .pipe(gulp.dest('img'))
            .pipe(notify(notification));

    });
