'use strict';

// Include gulp
var gulp = require('gulp');

// Include Our Plugins
var jshint = require('gulp-jshint');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var stylish = require('jshint-stylish');
var clean = require('gulp-clean');

// global config params
var config = {
	app: 'app',
	dist: 'dist',
	components: 'app/components'
};

// clean task
gulp.task('clean', function() {
	gulp.src(config.dist, {read: false})
		.pipe(clean());
});

// Copy task
gulp.task('copy', function(){
	gulp.src(['**/*.{php,md}', '!components/**/*'], { cwd : config.app })
		.pipe(gulp.dest('dist'));
});

// Lint Task
gulp.task('lint', function() {
	return gulp.src([config.app + '/js/*.js', 'gulpfile.js'])
		.pipe(jshint('./.jshintrc'))
		.pipe(jshint.reporter(stylish))
		.pipe(jshint.reporter('fail'));
});

// Concatenate & Minify JS
gulp.task('scripts', ['lint'], function() {
	return gulp.src([
		config.components + '/screenfull/dist/screenfull.min.js',
		config.app + '/js/*.js'
	])
	.pipe(concat('game-of-life.min.js'))
	.pipe(gulp.dest(config.dist + '/js'))
	.pipe(uglify())
	.pipe(gulp.dest(config.dist + '/js'));
});

// Watch Files For Changes
gulp.task('watch', function() {
	gulp.watch(config.app + '/js/*.js', ['lint', 'scripts']);
	gulp.watch(config.app + '/**/*.{php,md}', ['copy']);
});

// Default Task
gulp.task('default', ['clean', 'lint', 'scripts', 'copy']);