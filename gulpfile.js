/* Configuraion */

var paths = {
   css : 'web/resources/styles/css',
   scss : 'web/resources/styles/scss'
}


/* Require */
var gulp = require('gulp');
var cleanCSS = require('gulp-clean-css');
var $ = require('gulp-load-plugins')();



/* Tasks */
gulp.task('sass', function(){
   gulp.src(paths.scss + '/**/**/*.scss')
       .pipe($.sass().on('error', $.sass.logError))
       .pipe($.autoprefixer({browsers: ['last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4']}))
       .pipe(cleanCSS({compatibility: 'ie8'}))
       .pipe(gulp.dest(paths.css))
});


gulp.task('default', function(){
   gulp.watch(paths.scss + '/**/**/*.scss', ['sass'])
});



























//prefixer
//notify
//minify
//rename
//clean