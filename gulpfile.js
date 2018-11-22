var gulp = require('gulp'),
    runSequence = require('run-sequence'),
    clean = require('gulp-clean'),
    watch = require('gulp-watch')
    // sass = require('gulp-sass'),
    // concat = require('gulp-concat'),
    // minify = require('gulp-minify'),
    // uglify = require('gulp-uglify'),
    // merge = require('merge-stream'),
    // sourcemaps = require('gulp-sourcemaps')
;

var paths = {
    source: 'assets/',
    vendor: 'node_modules/',
    dest: 'public/assets/'
};

var js = {
    in: [
        paths.vendor + 'jquery/dist/jquery.min.js',
        paths.vendor + 'popper.js/dist/umd/popper.min.js',
        paths.vendor + 'bootstrap/dist/js/bootstrap.min.js',
        paths.vendor + '@fortawesome/fontawesome-free/js/all.min.js',
        paths.vendor + 'bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
        paths.vendor + 'moment/min//moment-with-locales.min.js',
    ],
    out: paths.dest + 'js/'
};

var css = {
    in:[
        paths.vendor + 'bootstrap/dist/css/bootstrap.min.css',
        paths.vendor + '@fortawesome/fontawesome-free/css/all.min.css',
        paths.vendor + 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
        paths.source + 'css/**/*',
    ],
    out: paths.dest + 'css/',
};

var fonts = {
    in: [
        paths.vendor + '@fortawesome/fontawesome-free/webfonts/*',
    ],
    out: paths.dest + 'webfonts/'
};

gulp.task('js', function () {
    return gulp
        .src(js.in)
        .pipe(gulp.dest(js.out));
});

gulp.task('css', function () {
    return gulp
        .src(css.in)
        .pipe(gulp.dest(css.out))
});

gulp.task('fonts', function () {
    return gulp
        .src(fonts.in)
        .pipe(gulp.dest(fonts.out))
});

gulp.task('clean', function () {
    return gulp
        .src(paths.dest, {read: false})
        .pipe(clean());
});

gulp.task('watch', ['default'], function () {
    watch(paths.source + 'scss/**/*.scss', function () {
        runSequence('adminCss');
        runSequence('css');
    });
    watch(paths.source + 'js/**/*', function () {
        runSequence('adminJs');
        runSequence('js');
    });
});

gulp.task('default', function() {
    return runSequence('clean', ['js', 'css', 'fonts']);
});
