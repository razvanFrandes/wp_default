var gulp            = require('gulp');
var sass            = require('gulp-sass');
var autoprefixer    = require('gulp-autoprefixer');
var sourcemaps      = require('gulp-sourcemaps');

var jsImport        = require('gulp-js-import');
var uglify          = require('gulp-uglify-es').default;
var concat          = require('gulp-concat');

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

var svgo = require('gulp-svgo');
var googleWebFonts  = require('gulp-google-webfonts');

const paths = {
    styles : {
        src : '../src/scss/style.scss',
        dist : '../dist/css',
        all : '../src/scss/**/*.*'
    },
    js : {
        src : '../src/js/main.js',
        dist : '../dist/js',
        all : '../src/js/**/*.js'
    },
    google : {
        options: {
            cssFilename: 'fonts.scss',
            fontsDir: '../dist/fonts/',
            cssDir: '../src/scss/core/',
            format: 'woff',
            fontDisplayType : 'swap'
        },
        fontsList : '../src/fonts/fonts.list',
        fontScss: '../src/scss/core/fonts.scss',
        replace: {
            x : 'url(../dist/fonts/',
            y : 'url(../fonts/'
        }
    },
    icons : {
        iconsPath: './../dist/img/svgFonts/*.svg',
        base:  'dist/fonts',
        dest: '../dist/fonts/',
        iconsFolder : '../dist/img/svgFonts',
        htmlIcons : '../dist/img/svgFonts/__svgFonts.html',
        iconFontCssOption: {
            fontName: 'icons',
            path: './../src/scss/core/icons--structure.css',
            targetPath: '../../src/scss/core/icons.scss',
            fontPath: '../fonts/',
            cssClass: 'ico'
        },
        iconFontOption: {
            fontName: 'icons',
            prependUnicode: true, // recommended option
            appendCodepoints: true,
            fontHeigth: 1001,
            normalize: true,
            formats: ['woff'], // default, 'woff2' and 'svg' are available
            timestamp: runTimestamp, // recommended to get consistent builds when watching files
        }
    }
}

// var styleSRC        = '../src/scss/style.scss';
// var styleSRCPaths   = '../src/scss/**/*.*';

// var styleURL        = '../dist/css';
// var mapURL          = './';

// var iconsFolder     = '../dist/img/svgFonts';
// var htmlIcons       = '../dist/img/svgFonts/__svgFonts.html';


//-------------------------------------                                  
// Styles
//
function styleDev() {
    return   gulp.src( paths.styles.src )
                .pipe( sourcemaps.init() )
                .pipe( sass({
                    errLogToConsole: true
                }) )
                .on( 'error', console.error.bind( console ) )
                .pipe( sourcemaps.write( './' ) )
                .pipe( gulp.dest( paths.styles.dist ))
                .pipe(notify({
                    message: 'SCSS DEV',
                    onLast: true
                }))
};

function styleProd() {
    return  gulp.src( paths.styles.src )
                .pipe( sass({
                    errLogToConsole: true,
                    outputStyle: 'compressed',
                }) )
                .on( 'error', console.error.bind( console ) )
                .pipe(autoprefixer( ['last 2 versions'] ) )
                .pipe( rename( { suffix: '.min' } ) )
                .pipe( gulp.dest(  paths.styles.dist ))
                .pipe(notify({
                    message: 'SCSS PROD',
                    onLast: true
                }))
}

//-------------------------------------                                  
// Scripts
//
function jsDev() {
    return  gulp.src( paths.js.src )
                .pipe(jsImport({hideConsole: true}))
                .pipe(concat('app.js'))
                .pipe(gulp.dest( paths.js.dist ))
                .pipe(notify({
                    message: 'JS DEV',
                    onLast: true
                })) 
}

function jsProd() {
    return  gulp.src( paths.js.src )
                .pipe(jsImport({hideConsole: true}))
                .pipe(concat('app.js'))
                .pipe(rename('app.min.js'))
                .pipe(uglify())
                .pipe(gulp.dest( paths.js.dist ))
                .pipe(notify({
                    message: 'JS PROD',
                    onLast: true
                }))
}

//-------------------------------------                                  
// Download Google Fonts
//
function googleFontsDownload() {
    return  gulp.src( paths.google.fontsList )
                .pipe(googleWebFonts( paths.google.options ))
                .pipe(gulp.dest('.'))
}

function googleFontsCss() {
        return  gulp.src( paths.google.fontScss , {base: "./"})
                    .pipe(replace( paths.google.replace.x , paths.google.replace.y))
                    .pipe(gulp.dest("./"));
}

//-------------------------------------
// SVG FONTS
//
function svgMin() {
    return gulp.src( paths.icons.iconsPath )
        .pipe(svgo())
        .pipe(gulp.dest( paths.icons.iconsFolder ));
}


function generateIcons() {
    return  gulp.src( paths.icons.iconsPath , { base: paths.icons.base } )
                .pipe(iconfontCss( paths.icons.iconFontCssOption ))
                .pipe(iconfont( paths.icons.iconFontOption ))
                .pipe(gulp.dest( paths.icons.dest ));                   
}

function generateHtmlIcons() {
    // Create HTML ICONS FILE
    return  fs.readdir(paths.icons.iconsFolder, (err, files) => {
                var iconsArray = [];    
                console.log(paths.icons.iconsFolder);
                files.forEach(file => {
                    iconsArray.push(file);
                });

                fs.readFile(paths.icons.htmlIcons, 'utf8', (err,html)=>{
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
                            body.appendChild('<div class="icon"><img src="'+file+'" ><span>.ico .ico-'+path.parse(file).name+'</span></div>');    
                        }                    
                    });
                    
                    fs.writeFile(paths.icons.htmlIcons, root.toString(), function(err) {
                        if(err) {
                            return console.log(err);
                        }
                    });
                });
            });
}


// Process
gulp.task('watch', function(){
    gulp.watch( paths.styles.all,  gulp.series(styleDev)  )
    gulp.watch( paths.js.all,  gulp.series(jsDev)  )
})
gulp.task('build',  gulp.series(styleProd, jsProd) )
gulp.task('fonts',  gulp.series(googleFontsDownload, googleFontsCss) )
gulp.task('iconsCustom',  gulp.series(svgMin, generateIcons, generateHtmlIcons) )