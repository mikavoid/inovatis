/* Configuration */
const paths = {
   css : 'web/resources/styles/css',
   scripts : 'web/resources/vendor/scripts',
   scss : 'web/resources/styles/scss',
   foundation_scss : 'node_modules/foundation-sites/scss',
    foundation_scripts : 'node_modules/foundation-sites/js'
}

/* Require */
const gulp = require('gulp')
const babel = require('gulp-babel')
const cleanCSS = require('gulp-clean-css')
const $ = require('gulp-load-plugins')()


/* Tasks */
/* Compilation du SASS */
gulp.task('sass', () => {
   gulp.src(paths.scss + '/**/**/*.scss')
       .pipe($.sass({
          includePaths: [
             paths.foundation_scss
          ]
       }).on('error', $.sass.logError))
       .pipe($.autoprefixer({browsers: ['last 2 versions', 'ie >= 9', 'and_chr >= 2.3']}))
       .pipe(cleanCSS({compatibility: 'ie8'}))
       .pipe(gulp.dest(paths.css))
})

/* Conversion du JS de Foundation*/
gulp.task('babel', () => {
    gulp.src(paths.foundation_scripts + '/**/*.js')
        .pipe(babel({
            presets: ['es2015']
        }))
        .pipe(gulp.dest(paths.scripts))
});

/* Tâche par défaut */
/* Ecoute les changement dans le dossier SASS et JS de Foundation */
gulp.task('default', function(){
   gulp.watch(paths.foundation_scripts + '/**/*.js', ['babel']);
   gulp.watch(paths.scss + '/**/**/*.scss', ['sass']);
});



























//prefixer
//notify
//minify
//rename
//clean