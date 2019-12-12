var gulp            = require('gulp');
var sass            = require('gulp-sass');
var autoprefixer    = require('gulp-autoprefixer');
var sourcemaps      = require('gulp-sourcemaps');

var jsImport        = require('gulp-js-import');
var uglify          = require('gulp-uglify-es').default;
var concat          = require('gulp-concat');
var babel           = require('gulp-babel');

var notify          = require('gulp-notify');
var rename          = require('gulp-rename');
var replace         = require('gulp-replace');
var runSequence     = require('run-sequence');

var iconfont        = require('gulp-iconfont');
var iconfontCss     = require('gulp-iconfont-css');
var parse           = require('node-html-parser').parse;
var path            = require('path');
var fs              = require('fs');
var runTimestamp    = Math.round(Date.now()/1000);

var googleWebFonts  = require('gulp-google-webfonts');

var styleSRC        = '../src/scss/style.scss';

var styleURL        = '../dist/css';
var mapURL          = './';

var iconsFolder     = '../dist/img/svgFonts';
var htmlIcons       = '../dist/img/svgFonts/__svgFonts.html';


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
});

//-------------------------------------                                  
// Concatenate JS for Development
//
gulp.task('scripts-dev', function() {
    return gulp.src('../src/js/main.js')
        .pipe(jsImport({hideConsole: true}))
        .pipe(concat('app.js'))
        .pipe(gulp.dest('../dist/js'))
        .pipe(notify({
            message: 'SCRIPT COMPILED DEV',
            onLast: true
        }))
});

//-------------------------------------                                  
// Concatenate & Minify JS for Production
//
gulp.task('scripts-prod', function() {
    return gulp.src('../src/js/main.js')
        .pipe(jsImport({hideConsole: true}))
        .pipe(concat('app.js'))
        .pipe(babel({
            presets: ['@babel/preset-env']
        }))
        .pipe(rename('app.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../dist/js'))
        .pipe(notify({
            message: 'SCRIPT COMPILED PROD',
            onLast: true
        }))
});

//-------------------------------------                                  
// Download Google Fonts
// Go to : assets/dist/fonts/fonts.list to add your fonts
//
var options = {
    cssFilename: 'fonts.scss',
    fontsDir: '../dist/fonts/',
    cssDir: '../src/scss/core/',
    format: 'woff'
};

gulp.task('google-fonts', function () {
    return gulp.src('../src/fonts/fonts.list')
        .pipe(googleWebFonts(options))
        .pipe(gulp.dest('.'))        ;
    });

gulp.task('fonts-url' , function() {
    return gulp.src( '../src/scss/core/fonts.scss', {base: "./"})
    .pipe(replace('url(../dist/fonts/', 'url(../fonts/'))
    .pipe(gulp.dest("./"));

});

// gulp.task('fonts', runSequence('google-fonts' , 'fonts-url' ));

//-------------------------------------
// SVG FONTS
gulp.task('icons', function(){
    gulp.src(['./../dist/img/svgFonts/*.svg'], {base: 'dist/fonts'} )
        .pipe(iconfontCss({
            fontName: 'icons',
            path: './../src/scss/core/icons--structure.css',
            targetPath: '../../src/scss/core/icons.scss',
            fontPath: '../fonts/',
            cssClass: 'ico'
        }))
        .pipe(iconfont({
            fontName: 'icons',
            prependUnicode: true, // recommended option
            appendCodepoints: true,
            fontHeigth: 1000,
            normalize: true,
            formats: ['woff'], // default, 'woff2' and 'svg' are available
            timestamp: runTimestamp, // recommended to get consistent builds when watching files
        }))
        .pipe(gulp.dest('../dist/fonts/'));    
        
        // Create HTML ICONS FILE
        fs.readdir(iconsFolder, (err, files) => {
            var iconsArray = [];    
            files.forEach(file => {
                iconsArray.push(file);

            });

            fs.readFile(htmlIcons, 'utf8', (err,html)=>{
                if(err){
                    throw err;
                }

                const root = parse(html, {
                    lowerCaseTagName: false,
                    script: true,
                    style: true,
                    pre: false  
                });

                let body = root.querySelector('body');
                body.set_content('');
                
                iconsArray.forEach(file => {
                    if ( file.includes('.svg') ) {
                        body.appendChild('<div class="icon"><img src="'+file+'" ><span>ico-'+path.parse(file).name+'</span></div>');    
                    }                    
                });
                
                fs.writeFile(htmlIcons, root.toString(), function(err) {
                    if(err) {
                        return console.log(err);
                    }
                });
            });
        });
    });

//-------------------------------------                                  
// Watch
//
gulp.task('watch', function() {

    // Watch .scss files
    gulp.watch(['../src/scss/**/*.scss', '../src/scss/**/*.sass'], ['styles-dev']);

    // Watch .js files
    gulp.watch('../src/js/**/*.js', ['scripts-dev']);

    
});

gulp.task('build', ['styles-prod', 'scripts-prod']);