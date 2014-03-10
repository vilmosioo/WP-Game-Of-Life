'use strict';

// Include gulp
var gulp = require('gulp'); 

// Include Our Plugins
var jshint = require('gulp-jshint');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');

// global config params
var config = {
	app: 'app',
	dist: 'dist'
}

// Lint Task
gulp.task('lint', function() {
	return gulp.src(config.app + '/js/*.js')
		.pipe(jshint())
		.pipe(jshint.reporter('default'));
});

// Concatenate & Minify JS
gulp.task('scripts', function() {
	return gulp.src(config.app + '/js/*.js')
		.pipe(concat('game-of-life.js'))
		.pipe(gulp.dest('dist'))
		.pipe(rename('game-of-life.min.js'))
		.pipe(uglify())
		.pipe(gulp.dest('dist'));
});

// Watch Files For Changes
gulp.task('watch', function() {
	gulp.watch(config.app + '/js/*.js', ['lint', 'scripts']);
});

// Default Task
gulp.task('default', ['lint', 'scripts']);