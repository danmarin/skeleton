var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var minifycss = require('gulp-minify-css');
var uglify = require('gulp-uglify');

gulp.task('css', function () {
	gulp.src('assets/sass/**/*.scss')
		.pipe(sass({errLogToConsole: true}))
		.pipe(autoprefixer('last 15 versions'))
		.pipe(minifycss())
		.pipe(gulp.dest('public/assets/css'))
});

gulp.task('compress', function () {
	gulp.src('assets/js/**/*.js')
		.pipe(uglify())
		.pipe(gulp.dest('public/assets/js'))
});

gulp.task('images', function () {
	gulp.src('assets/images/**/*.jpg')
		.pipe(gulp.dest('public/assets/images'));

	gulp.src('assets/images/**/*.png')
		.pipe(gulp.dest('public/assets/images'));

	gulp.src('assets/images/**/*.gif')
		.pipe(gulp.dest('public/assets/images'));
});

gulp.task('watch', function () {
	gulp.watch('assets/sass/**/*.scss', ['css']);
	gulp.watch('assets/js/**/*.js', ['compress']);
	gulp.watch('assets/images/**/*.jpg', ['images']);
	gulp.watch('assets/images/**/*.png', ['images']);
	gulp.watch('assets/images/**/*.gif', ['images']);
});

gulp.task('default', ['watch']);