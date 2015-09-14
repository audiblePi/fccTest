// Load plugins
var gulp = require('gulp'),
	plugins = require('gulp-load-plugins')({ camelize: true }),
	lr = require('tiny-lr'),
	server = lr();

// Styles
gulp.task('styles', function() {
  return gulp.src('assets/css/source/style.scss')
	.pipe(plugins.rubySass({ style: 'expanded', sourcemap: true }))
	.pipe(plugins.autoprefixer('last 2 versions', 'ie 9', 'ios 6', 'android 4'))
	.pipe(gulp.dest('assets/css/build'))
	// .pipe(plugins.minifyCss({ keepSpecialComments: 1 }))
	// .pipe(plugins.livereload(server))
	.pipe(gulp.dest('./'))
	.pipe(plugins.notify({ message: 'Sass compile task complete' }));
});

// Reload styles only AFTER sass has compiled
// This is a fix to prevent task.styles from reloading
// entire page.
gulp.task('wpstylechange', function(){
	return gulp.src('style.css')
	.pipe(plugins.livereload(server))
	.pipe(plugins.notify({ message: 'style.css injected' }));
})

gulp.task('htmlchange', function(){
	return gulp.src(['./*.php'])
	.pipe(plugins.livereload(server))
	.pipe(plugins.notify({ message: 'Markup reloaded' }))
})

// Vendor Plugin Scripts
// gulp.task('plugins', function() {
//   return gulp.src(['assets/js/source/plugins.js', 'assets/js/vendor/*.js'])
// 	.pipe(plugins.concat('plugins.js'))
// 	.pipe(gulp.dest('assets/js/build'))
// 	.pipe(plugins.rename({ suffix: '.min' }))
// 	.pipe(plugins.uglify())
// 	.pipe(plugins.livereload(server))
// 	.pipe(gulp.dest('assets/js'))
// 	.pipe(plugins.notify({ message: 'Scripts task complete' }));
// });

// Site Scripts
// gulp.task('scripts', function() {
//   return gulp.src(['assets/js/source/*.js', '!assets/js/source/plugins.js'])
// 	.pipe(plugins.jshint('.jshintrc'))
// 	.pipe(plugins.jshint.reporter('default'))
// 	.pipe(plugins.concat('main.js'))
// 	.pipe(gulp.dest('assets/js/build'))
// 	.pipe(plugins.rename({ suffix: '.min' }))
// 	.pipe(plugins.uglify())
// 	.pipe(plugins.livereload(server))
// 	.pipe(gulp.dest('assets/js'))
// 	.pipe(plugins.notify({ message: 'Scripts task complete' }));
// });

// Images
gulp.task('images', function() {
  return gulp.src('assets/images/original/*')
	.pipe(plugins.cache(plugins.imagemin({ optimizationLevel: 7, progressive: true, interlaced: true })))
	.pipe(plugins.livereload(server))
	.pipe(gulp.dest('assets/images'))
	.pipe(plugins.notify({ message: 'Images task complete' }));
});

// Watch
gulp.task('watch', function() {

  // Listen on port 35729
  server.listen(35729, function (err) {
	if (err) {
	  return console.log(err)
	};

	// Watch .scss files
	gulp.watch('assets/css/source/style.scss', ['styles']);

	gulp.watch('assets/css/source/partials/*.scss', ['styles']);

	gulp.watch('style.css', ['wpstylechange']);

	gulp.watch('./*.php', ['htmlchange']);

	// Watch .js files
	// gulp.watch('assets/js/**/*.js', ['plugins', 'scripts']);

	// Watch image files
	// gulp.watch('assets/images/original/*', ['images']);

  });

});

// Default task
// gulp.task('default', ['styles', 'plugins', 'scripts', 'images', 'watch']);
gulp.task('default', ['styles', 'watch']);