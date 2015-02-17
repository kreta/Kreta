/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

'use strict';

var gulp = require('gulp');
var del = require('del');
var to5 = require('gulp-6to5');
var compass = require('gulp-compass');
var concat = require('gulp-concat');
var header = require('gulp-header');
var imagemin = require('gulp-imagemin');
var jshint = require('gulp-jshint');
var minifyCSS = require('gulp-minify-css');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var pkg = require('./package.json');

var basePath = './../../../../web/bundles/kretaweb/';
var resultPath = './../../../../web/';

var license = [
  '/**',
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
  sass: basePath + 'scss/app.scss',
  vendors: basePath + 'vendor/**'
};

gulp.task('clean', function () {
  del.sync([
    resultPath + 'css/**',
    resultPath + 'images/**',
    resultPath + 'js/**',
    resultPath + 'vendor/**'
  ], {force: true});
});

gulp.task('images', ['clean'], function () {
  return gulp.src(assets.images)
    //.pipe(imagemin({optimizationLevel: 5}))
    .pipe(gulp.dest(resultPath + 'images'));
});

gulp.task('vendor', ['clean'], function () {
  return gulp.src(assets.vendors)
    .pipe(gulp.dest(resultPath + 'vendor'));
});

gulp.task('sass', ['clean'], function () {
  return gulp.src(assets.sass)
    .pipe(compass({
      style: 'expanded',
      debugInfo: true,
      sass: basePath + 'scss',
      css: resultPath + 'css'
    }))
    .pipe(rename({basename: 'kreta'}))
    .pipe(gulp.dest(resultPath + 'css'));
});

gulp.task('sass:prod', ['clean'], function () {
  return gulp.src(assets.sass)
    .pipe(compass({
      sass: basePath + 'scss',
      css: resultPath + 'css'
    }))
    .pipe(rename({
      basename: 'kreta',
      suffix: '.min'
    }))
    .pipe(minifyCSS({keepSpecialComments: 0}))
    .pipe(header(license, {pkg: pkg}))
    .pipe(gulp.dest(resultPath + 'css'));
});

gulp.task('javascript', ['clean'], function () {
  return gulp.src(assets.javascripts)
    .pipe(jshint())
    .pipe(jshint.reporter('default'))
    //.pipe(to5({blacklist: ['useStrict'], modules: ['amd'] }))
    .pipe(gulp.dest(resultPath + 'js'));
});

gulp.task('javascript:prod', ['clean'], function () {
  return gulp.src(assets.javascripts)
    //.pipe(to5({blacklist: ['useStrict'], modules: ['amd'] }))
    .pipe(concat('kreta.min.js'))
    .pipe(uglify())
    .pipe(header(license, {pkg: pkg}))
    .pipe(gulp.dest(resultPath + 'js'));
});

gulp.task('watch', function () {
  gulp.watch(assets.javascripts, ['javascript']);
  gulp.watch(assets.sass, ['sass']);
  gulp.watch(assets.images, ['images']);
});

gulp.task('default', ['clean', 'vendor', 'javascript', 'sass', 'images']);
gulp.task('watcher', ['default', 'watch']);
gulp.task('prod', ['clean', 'images', 'sass:prod', 'javascript:prod']);
