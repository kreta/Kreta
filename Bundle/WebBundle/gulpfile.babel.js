/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import gulp from 'gulp';
import autoprefixer from 'gulp-autoprefixer';
import babel from 'gulp-babel';
import babelify from 'babelify';
import browserify from 'browserify';
import buffer from 'vinyl-buffer';
import del from 'del';
import concat from 'gulp-concat';
import eslint from 'gulp-eslint';
import header from 'gulp-header';
import imagemin from 'gulp-imagemin';
import minifyCSS from 'gulp-minify-css';
import minimist from 'minimist';
import notify from 'gulp-notify';
import rename from 'gulp-rename';
import sass from 'gulp-sass';
import source from 'vinyl-source-stream';
import sourcemaps from 'gulp-sourcemaps';
import scsslint from 'gulp-scss-lint';
import uglify from 'gulp-uglify';
import watchify from 'watchify';

import pkg from './package.json';

var knownOptions = {string: 'from', default: {from: ''}},
  options = minimist(process.argv.slice(2), knownOptions),
  fromVendorPath = options.from === 'vendor' ? '/../' : '/';

const BASE_PATH = `./../../../..${fromVendorPath}web/bundles/kretaweb/`,
  RESULT_PATH = `./../../../..${fromVendorPath}web/`,

  LICENSE = [`/*
 * <%= pkg.name %> - <%= pkg.description %>
 *
 * @link <%= pkg.homepage %>
 *
 * @author <%= pkg.authors[0].name %> (<%= pkg.authors[0].homepage %>)
 * @author <%= pkg.authors[1].name %> (<%= pkg.authors[1].homepage %>)
 *
 * @license <%= pkg.license %>
 */

`],

  ASSETS = {
    images: `${BASE_PATH}img/**`,
    javascripts: {
      path: `${BASE_PATH}js/**/*.js`,
      index: `${BASE_PATH}js/kreta.js`
    },
    sass: `${BASE_PATH}scss/**.scss`,
    vendors: `${BASE_PATH}vendor/**`
  },

  WATCH = {
    sass: `${BASE_PATH}scss/**/*.scss`
  };

gulp.task('clean', () => {
  del.sync([
    `${RESULT_PATH}css*`,
    `${RESULT_PATH}images*`,
    `${RESULT_PATH}js*`,
    `${RESULT_PATH}vendor*`
  ], {force: true});
});

gulp.task('images', () => {
  return gulp.src(ASSETS.images)
    .pipe(imagemin({optimizationLevel: 5}))
    .pipe(gulp.dest(`${RESULT_PATH}images`));
});

gulp.task('vendor', () => {
  return gulp.src(ASSETS.vendors)
    .pipe(gulp.dest(`${RESULT_PATH}vendor`));
});

gulp.task('vendor:prod', () => {
  return gulp.src(ASSETS.vendors)
    .pipe(gulp.dest(`${RESULT_PATH}vendor`));
});

gulp.task('scss-lint', () => {
  return gulp.src(WATCH.sass)
    .pipe(scsslint());
});

gulp.task('sass', ['scss-lint'], () => {
  return gulp.src(ASSETS.sass)
    .pipe(sourcemaps.init())
    .pipe(sass({
      style: 'expanded',
      lineNumbers: true,
      loadPath: true,
      errLogToConsole: true
    }))
    .pipe(autoprefixer())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(`${RESULT_PATH}css`));
});

gulp.task('sass:prod', () => {
  return gulp.src(ASSETS.sass)
    .pipe(sass({
      style: 'compressed',
      errLogToConsole: true
    }))
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(autoprefixer())
    .pipe(minifyCSS({keepSpecialComments: 0}))
    .pipe(header(LICENSE, {pkg}))
    .pipe(gulp.dest(`${RESULT_PATH}css`));
});

gulp.task('eslint', () => {
  return gulp.src(ASSETS.javascripts.path)
    .pipe(eslint({'configFile': './.eslint.yml'}))
    .pipe(eslint.format());
});

gulp.task('js', [], () => {
  const bundler = watchify(
    browserify(
      ASSETS.javascripts.index, watchify.args
    )
  );

  function rebundle() {
    return bundler
      .bundle()
      .on('error', notify.onError())
      .pipe(source('kreta.js'))
      .pipe(gulp.dest(`${RESULT_PATH}js`));
  }

  bundler.transform(babelify)
    .on('update', rebundle);
  return rebundle();
});

gulp.task('js:prod', () => {
  browserify(ASSETS.javascripts.index)
    .transform(babelify)
    .bundle()
    .pipe(source('kreta.min.js'))
    .pipe(buffer())
    .pipe(uglify())
    .pipe(header(LICENSE, {pkg}))
    .pipe(gulp.dest(`${RESULT_PATH}js`));
});

gulp.task('watch', () => {
  gulp.watch(WATCH.sass, ['sass']);
  gulp.watch(ASSETS.images, ['images']);
});

gulp.task('default', ['clean', 'vendor', 'js', 'sass', 'images']);
gulp.task('prod', ['clean', 'vendor', 'js:prod', 'sass:prod', 'images']);
gulp.task('watcher', ['default', 'watch']);
