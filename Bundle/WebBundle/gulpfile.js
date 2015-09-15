/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

'use strict';

var gulp = require('gulp');
var autoprefixer = require('gulp-autoprefixer');
var babel = require('gulp-babel');
var del = require('del');
var concat = require('gulp-concat');
var eslint = require('gulp-eslint');
var header = require('gulp-header');
var imagemin = require('gulp-imagemin');
var minifyCSS = require('gulp-minify-css');
var minimist = require('minimist');
var rename = require('gulp-rename');
var sass = require('gulp-sass');
var scsslint = require('gulp-scss-lint');
var sourcemaps = require('gulp-sourcemaps');
var uglify = require('gulp-uglify');

var pkg = require('./package.json');

var knownOptions = {string: 'from', default: {from: ''}};
var options = minimist(process.argv.slice(2), knownOptions);
var fromVendorPath = options.from === 'vendor' ? '/../' : '/';

var basePath = './../../../..' + fromVendorPath + 'web/bundles/kretaweb/';
var resultPath = './../../../..' + fromVendorPath + 'web/';

var license = [
  '/*',
  ' * <%= pkg.name %> - <%= pkg.description %>',
  ' * @version v<%= pkg.version %>',
  ' * @link    <%= pkg.homepage %>',
  ' * @author  <%= pkg.authors[0].name %> (<%= pkg.authors[0].homepage %>)',
  ' * @author  <%= pkg.authors[1].name %> (<%= pkg.authors[1].homepage %>)',
  ' * @license <%= pkg.license %>',
  ' */',
  "\n"
].join("\n");

var assets = {
  images: basePath + 'img/**',
  javascripts: basePath + 'js/**/*.js',
  sass: basePath + 'scss/**.scss',
  vendors: basePath + 'vendor/**'
};

var watch = {
  sass: basePath + 'scss/**/*.scss'
};

gulp.task('clean', function () {
  del.sync([
    resultPath + 'css*',
    resultPath + 'images*',
    resultPath + 'js*',
    resultPath + 'vendor*'
  ], {force: true});
});

gulp.task('images', function () {
  return gulp.src(assets.images)
    //.pipe(imagemin({optimizationLevel: 5}))
    .pipe(gulp.dest(resultPath + 'images'));
});

gulp.task('vendor', function () {
  return gulp.src(assets.vendors)
    .pipe(gulp.dest(resultPath + 'vendor'));
});

gulp.task('vendor:prod', function () {
  return gulp.src(assets.vendors)
    .pipe(gulp.dest(resultPath + 'vendor'));
});

gulp.task('scss-lint', function () {
  return gulp.src(watch.sass)
    .pipe(scsslint());
});

gulp.task('sass', ['scss-lint'], function () {
  return gulp.src(assets.sass)
    .pipe(sourcemaps.init())
    .pipe(sass({
      style: 'expanded',
      lineNumbers: true,
      loadPath: true,
      errLogToConsole: true
    }))
    .pipe(autoprefixer())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(resultPath + 'css'));
});

gulp.task('sass:prod', function () {
  return gulp.src(assets.sass)
    .pipe(sass({
      style: 'compressed',
      errLogToConsole: true
    }))
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(autoprefixer())
    .pipe(minifyCSS({keepSpecialComments: 0}))
    .pipe(header(license, {pkg: pkg}))
    .pipe(gulp.dest(resultPath + 'css'));
});

gulp.task('javascript', function () {
  return gulp.src(assets.javascripts)
    .pipe(eslint({'configFile': './.eslint.yml'}))
    .pipe(eslint.format())
    .pipe(babel({blacklist: ['useStrict'], comments: false, modules: ['amd']}))
    .pipe(gulp.dest(resultPath + 'js'));
});

gulp.task('javascript:prod', function () {
  return gulp.src(assets.javascripts)
    .pipe(babel({blacklist: ['useStrict'], comments: false, modules: ['amd']}))
    .pipe(concat('app.min.js'))
    .pipe(uglify())
    .pipe(header(license, {pkg: pkg}))
    .pipe(gulp.dest(resultPath + 'js'));
});

gulp.task('watch', function () {
  gulp.watch(assets.javascripts, ['javascript']);
  gulp.watch(watch.sass, ['sass']);
  gulp.watch(assets.images, ['images']);
});

gulp.task('default', ['clean', 'vendor', 'javascript', 'sass', 'images']);
gulp.task('watcher', ['default', 'watch']);
gulp.task('prod', ['clean', 'vendor', 'images', 'sass:prod', 'javascript']); //'javascript:prod']);
