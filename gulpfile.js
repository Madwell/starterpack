var gulp    = require('gulp'),
    gutil   = require('gulp-util'),
    uglify  = require('gulp-uglify'),
    concat  = require('gulp-concat'),
    sass    = require('gulp-sass'),
    debug  = require('gulp-debug');
    livereload  = require('gulp-livereload');

// Handle errors
function errorHandler (error) {
    console.log(error.toString());
    this.emit('end');
}

gulp.task('uglify-concat', function () {
    gulp.src([
            './public_html/wp-content/themes/CHANGEME/js/interaction.js',
        ])
        .pipe(debug())
        .pipe(uglify())
        .on('error', errorHandler)
        .pipe(concat('app.min.js'))
        .pipe(gulp.dest('./public_html/wp-content/themes/CHANGEME/js'))
        .pipe(livereload());
});

gulp.task('concat', function () {
    gulp.src([
            './public_html/wp-content/themes/CHANGEME/js/interaction.js',
        ])
        .pipe(debug())
        .on('error', errorHandler)
        .pipe(concat('app.js'))
        .pipe(gulp.dest('./public_html/wp-content/themes/CHANGEME/js'))
        .pipe(livereload());
});

gulp.task('sass', function() {
    gulp.src('./public_html/wp-content/themes/CHANGEME/css/theme.scss')
        .pipe(debug())
        .on('error', errorHandler)
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(gulp.dest('./public_html/wp-content/themes/CHANGEME/css'))
        .pipe(livereload());
});

gulp.task('watch', function() {

    livereload.listen();

    // Watch all SCSS 
    gulp.watch('./public_html/wp-content/themes/CHANGEME/css/*.scss', ['sass']);

    // Watch all JS except compiled files
    gulp.watch([
            './public_html/wp-content/themes/CHANGEME/js/*.js',
            '!./public_html/wp-content/themes/CHANGEME/js/app.min.js',
            '!./public_html/wp-content/themes/CHANGEME/js/app.js'
        ], [
            'uglify-concat',
            'concat'
        ]);

});

gulp.task('default', [
    'uglify-concat',
    'concat',
    'sass',
    'watch',
]);