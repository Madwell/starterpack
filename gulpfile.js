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

gulp.task('uglify-then-concat-js', function () {
    gulp.src([
            './public_html/wp-content/themes/CHANGEME/js/interaction.js',
    	])
    	.pipe(debug())
        .pipe(uglify())
        .on('error', errorHandler)
        .pipe(concat('app.js'))
        .pipe(gulp.dest('./public_html/wp-content/themes/CHANGEME/js'))
        .pipe(livereload());
});

gulp.task('compile-sass', function() {
	gulp.src('./public_html/wp-content/themes/CHANGEME/css/theme.scss')
    	.pipe(debug())
        .on('error', errorHandler)
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(gulp.dest('./public_html/wp-content/themes/CHANGEME/css'))
        .pipe(livereload());
});

// Don't bother uglifying JS if working locally, using watch
gulp.task('watch', function() {

    livereload.listen();
    gulp.watch('./public_html/wp-content/themes/CHANGEME/css/*.scss', ['compile-sass']);
    gulp.watch('./public_html/wp-content/themes/CHANGEME/js/interaction.js', ['uglify-then-concat-js']);

});

gulp.task('default', [
	'uglify-then-concat-js',
	'compile-sass',
    'watch',
]);