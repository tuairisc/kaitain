/**
 *  Gulp Build Script
 * -----------------------------------------------------------------------------
 * @category   Node.js Build File
 * @package    Kaitain
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/kaitain-theme
 * @link       http://www.tuairisc.ie
 */

//
// Modules
//

var gulp = require('gulp');
var sass = require('gulp-ruby-sass');
var prefixer = require('gulp-autoprefixer');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var sourcemap = require('gulp-sourcemaps');
var replace = require('gulp-replace');
var penthouse = require('penthouse');
var fs = require('fs');
var concat = require('gulp-concat');

//
// Assets Paths
//

var assets = {
    css: {
        main: 'assets/css/style.css',
        critical: 'assets/css/critical.css',
        source: 'assets/css/**/*.scss',
        dest: 'assets/css/'
    },
    js: {
        concat: 'kaitain.js',
        source: 'assets/js/*.js',
        dest: 'assets/js/min/'
    },
    sprites: {
        source: 'assets/css/includes/**/*.svg',
        dest: 'assets/css/vectors'
    }
};

//
// Penthouse
//

var phouse = {
    // DEBUG
    url: 'https://kaitain.bhalash.com',
    // url: 'http://www.tuairisc.ie',
    css: assets.css.main,
    // Sizes are optimized for mobile delivery, targeting the iPhone 5S.
    width: 320,
    height: 568
};

//
// Autoprefixer
//

var prefixes = [
    // Autoprefixer.
    'last 1 version', 
    '> 1%',
    'ie 10',
    'ie 9'
];

//
// Regex Replacements
//

var regex = {
    comments: {
        // Remove block comments from unminified output CSS.
        match: /^(\/\*|\s\*|\s{3}=).*[\n\r]/mg,
        replace: ''
    }
};

// 
// Optimize Production CSS Layout
//

gulp.task('penthouse', function() {
    penthouse(phouse, function(error, css) {
        if (error) {
            console.log(error);
            console.log(css);
        }

        fs.writeFile(assets.css.main, css);
    });
});

//
// Move Up Sprite Assets
//

gulp.task('sprites', function() {
    gulp.src(assets.sprites.source)
        .pipe(gulp.dest(assets.sprites.dest));
});

//
// Production Minified CSS
//

gulp.task('css', function() {
    sass(assets.css.source, {
        emitCompileError: true,
        style: 'compressed'
    })
    .on('error', sass.logError)
    .pipe(prefixer(prefixes))
    .pipe(gulp.dest(assets.css.dest));
});

// 
// Uniminified Test CSS with Sourcemap
//

gulp.task('css-dev', function() {
    // Development unminified sass, with sourcemap.
    return sass(assets.css.source, {
            emitCompileError: true,
            sourcemap: true
        })
        .on('error', sass.logError)
        .pipe(replace(regex.comments.match, regex.comments.replace))
        .pipe(prefixer(prefixes))
        .pipe(sourcemap.write())
        .pipe(gulp.dest(assets.css.dest));
});

// 
// Minify JS Files
//

gulp.task('js', function() {
    // Minify all scripts in the JS folder.
    return gulp.src(assets.js.source)
        .pipe(uglify())
        .pipe(concat(assets.js.concat))
        .pipe(gulp.dest(assets.js.dest));
});

// 
// Watch Tasks
//

gulp.task('default', function() {
    gulp.watch(assets.css.source, ['css']);
});

gulp.task('dev', function() {
    gulp.watch(assets.css.source, ['css-dev']);
});
