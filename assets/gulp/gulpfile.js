var gulp            = require('gulp');
var sass            = require('gulp-sass');
var autoprefixer    = require('gulp-autoprefixer');
var sourcemaps      = require('gulp-sourcemaps');

var jsImport        = require('gulp-js-import');
var uglify          = require('gulp-uglify');
var concat          = require('gulp-concat');

var notify          = require('gulp-notify');
var rename          = require('gulp-rename');
var replace         = require('gulp-replace');
var runSequence     = require('run-sequence');

var livereload      = require('gulp-livereload');
var googleWebFonts  = require('gulp-google-webfonts');
var gulps           = require("gulp-series");

var browserSync     = require('browser-sync');
var reload          = browserSync.reload;

var styleSRC        = '../src/scss/style.scss';
var styleAdminSRC   = '../src/scss/admin.scss';
var styleURL        = '../dist/css';
var mapURL          = './';


//-------------------------------------                                  
// Styles for Development
//
gulp.task( 'styles-dev', function() {
    gulp.src([ styleSRC ])
    .pipe( sourcemaps.init() )
    .pipe( sass({
        errLogToConsole: true
    }) )
    .on( 'error', console.error.bind( console ) )
    .pipe( sourcemaps.write( mapURL ) )
    .pipe( gulp.dest( styleURL ))
    .pipe(notify({
        message: 'SCSS COMPILED DEV',
        onLast: true
    }))
    .pipe( livereload() )
});


//-------------------------------------                                  
// Styles for Production          
//
gulp.task( 'styles-prod', function() {
    gulp.src([ styleSRC ])
    .pipe( sass({
        errLogToConsole: true,
        outputStyle: 'compressed'
    }) )
    .on( 'error', console.error.bind( console ) )
    .pipe(autoprefixer( ['> 0.000001%']) )
    .pipe( rename( { suffix: '.min' } ) )
    .pipe( sourcemaps.write( mapURL ) )
    .pipe( gulp.dest( styleURL ))
    .pipe(notify({
        message: 'SCSS COMPILED PROD',
        onLast: true
    }))
    .pipe( browserSync.stream() );
});

//-------------------------------------                                  
// Concatenate JS for Development
//
gulp.task('scripts-dev', function() {
    return gulp.src('../src/js/main.js')
        .pipe(jsImport({hideConsole: true}))
        .pipe(concat('app.js'))
        .pipe(gulp.dest('../dist/js'))
        .pipe( livereload() )
        .pipe( browserSync.stream() );
});

//-------------------------------------                                  
// Concatenate & Minify JS for Production
//
gulp.task('scripts-prod', function() {
    return gulp.src('../src/js/main.js')
        .pipe(jsImport({hideConsole: true}))
        .pipe(concat('app.js'))
        .pipe(rename('app.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../dist/js'))
});


//-------------------------------------                                  
// Browser Sync
// 


gulp.task('browser-sync', function() {
    browserSync.init({
        open: false,
        injectChanges: true,
        proxy: "http://myTheme.local/"
    });

    // browserSync.init( files, {
    //     proxy: "http://myTheme.local/",
    //     notify: false
    // });

    // var files = [
    //     './assets/src/scss/*.scss',
    //     './assets/src/scss/**/*.scss',
    //     './assets/src/js/**/*.js',
    //     './assets/src/js/**/*.js',
    //     './*.php',
    //     './**/*.php',
    // ];

    // Init browserSync
});


//-------------------------------------                                  
// Download Google Fonts
// Go to : assets/dist/fonts/fonts.list to add your fonts
//
var options = {
    cssFilename: '_02_fonts.scss',
    fontsDir: '../dist/fonts/',
    cssDir: '../src/scss/03_core/',
    format: 'woff'
};

gulp.task('google-fonts', function () {
    return gulp.src('../src/fonts/fonts.list')
        .pipe(googleWebFonts(options))
        .pipe(gulp.dest('.'))        ;
    });

gulp.task('fonts-url' , function() {
    return gulp.src( '../src/scss/03_core/_02_fonts.scss', {base: "./"})
    .pipe(replace('url(../dist/fonts/', 'url(../fonts/'))
    .pipe(gulp.dest("./"));

});

// gulp.task('fonts', runSequence('google-fonts' , 'fonts-url' ));




//-------------------------------------                                  
// Watch
//
gulp.task('watch', ['browser-sync'], function() {

    // Watch .scss files
    gulp.watch('../src/scss/**/*.scss', ['styles-dev', reload]);

    // Watch .js files
    gulp.watch('../src/js/**/*.js', ['scripts-dev', reload]);

    
});

gulp.task('build', ['styles-prod', 'scripts-prod']);