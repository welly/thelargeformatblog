var config = {
  sassPath: "./sass",
  cssPath: './css',
  bowerPath: './bower_components',
  fontsPath: './fonts',
  vendorPath: './vendor',
}

var jsComponents = [
  config.bowerPath + "/jquery/dist/**/*.js",
];

var sassComponents = [
  config.bowerPath + "/jeet.gs/scss/**/*.scss",
];

var onError = function (err) {
  gutil.beep();
  console.log(err);
};

var bower        = require('main-bower-files');
var autoprefixer = require('gulp-autoprefixer');
var compass      = require('gulp-compass');
var gulp         = require('gulp');
var gulpfilter   = require('gulp-filter');
var gutil        = require('gulp-util');
var minifycss    = require('gulp-minify-css');
var notify       = require('gulp-notify');
var plumber      = require('gulp-plumber');
var rename       = require('gulp-rename');
var notifyInfo = {
  title: 'Gulp',
};

//error notification settings for plumber
var plumberErrorHandler = {
  errorHandler: notify.onError({
    title: notifyInfo.title,
    message: "Error: <%= error.message %>"
  })
};

// gulp.task('icons', function() { 
//   return gulp.src(config.bowerPath + '/fontawesome/fonts/**.*') 
//     .pipe(plumber(plumberErrorHandler))
//     .pipe(gulp.dest(config.fontsPath)); 
// });

// gulp.task('bower-css', function() {
//   return gulp.src(bower())
//     .pipe(plumber(plumberErrorHandler))
//     .pipe(gulpfilter('*.css'))
//     .pipe(rename({suffix: '.min'}))
//     .pipe(gulp.dest(config.cssPath));
// });

gulp.task("bower-sass", function() {
  return gulp.src(sassComponents, {base: config.bowerPath})
    .pipe(plumber(plumberErrorHandler))
    .pipe(gulp.dest(config.vendorPath))
    .pipe(notify("Task 'bower-sass': Complete"));
});

gulp.task("bower-js", function() {
  return gulp.src(jsComponents, {base: config.bowerPath})
    .pipe(plumber(plumberErrorHandler))
    .pipe(gulp.dest(config.vendorPath))
    .pipe(notify("Task 'bower-js': Complete"));
});

gulp.task('sass', function() {
  return gulp.src(config.sassPath + '/**/*.scss')
    .pipe(plumber(plumberErrorHandler))
    .pipe(compass({
      bundle_exec: true,
      config_file: './config.rb',
      sourcemap: true,
      css: 'css',
      sass: 'sass',
    }))
    // Commenting out autoprefixer due to it stripping sourcemaps out.
    .pipe(autoprefixer({
      browsers: ['> 5%', 'last 2 versions', 'ie 8', 'ie 9', 'chrome 5'],
    }))
    .pipe(gulp.dest(config.cssPath))
    .pipe(notify("Task 'sass': Complete"));
});

gulp.task("watch", function() {
  gulp.watch(config.sassPath + '/**/*.scss', ['sass']); 
});

gulp.task('default', ['bower-sass', 'sass'], function() {
});