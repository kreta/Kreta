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
import del from 'del';
import concat from 'gulp-concat';
import eslint from 'gulp-eslint';
import header from 'gulp-header';
import imagemin from 'gulp-imagemin';
import minifyCSS from 'gulp-minify-css';
import minimist from 'minimist';
import rename from 'gulp-rename';
import sass from 'gulp-sass';
import scsslint from 'gulp-scss-lint';
import sourcemaps from 'gulp-sourcemaps';
import uglify from 'gulp-uglify';

import pkg from './package.json';

var knownOptions = {string: 'from', default: {from: ''}},
  options = minimist(process.argv.slice(2), knownOptions),

  fromVendorPath = options.from === 'vendor' ? '/../' : '/',
  basePath = `./../../../..${fromVendorPath}web/bundles/kretaweb/`,
  resultPath = `./../../../..${fromVendorPath}web/`,

  license = [`/*
 * <%= pkg.name %> - <%= pkg.description %>
 *
 * @link    <%= pkg.homepage %>
 *
 * @author  <%= pkg.authors[0].name %> (<%= pkg.authors[0].homepage %>)
 * @author  <%= pkg.authors[1].name %> (<%= pkg.authors[1].homepage %>)
 *
 * @license <%= pkg.license %>
 */

`],

  assets = {
    images: `${basePath}img/**`,
    javascripts: `${basePath}js/**/*.js`,
    sass: `${basePath}scss/**.scss`,
    vendors: `${basePath}vendor/**`
  },

  watch = {
    sass: `${basePath}scss/**/*.scss`
  };

gulp.task('clean', () => {
  del.sync([
    `${resultPath}css*`,
    `${resultPath}images*`,
    `${resultPath}js*`,
    `${resultPath}vendor*`
  ], {force: true});
});

gulp.task('images', () => {
  return gulp.src(assets.images)
    .pipe(imagemin({optimizationLevel: 5}))
    .pipe(gulp.dest(`${resultPath}images`));
});

gulp.task('vendor', () => {
  return gulp.src(assets.vendors)
    .pipe(gulp.dest(`${resultPath}vendor`));
});

gulp.task('vendor:prod', () => {
  return gulp.src(assets.vendors)
    .pipe(gulp.dest(`${resultPath}vendor`));
});

gulp.task('scss-lint', () => {
  return gulp.src(watch.sass)
    .pipe(scsslint());
});

gulp.task('sass', ['scss-lint'], () => {
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
    .pipe(gulp.dest(`${resultPath}css`));
});

gulp.task('sass:prod', () => {
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
    .pipe(header(license, {pkg}))
    .pipe(gulp.dest(`${resultPath}css`));
});

gulp.task('js', () => {
  return gulp.src(assets.javascripts)
    .pipe(eslint({'configFile': './.eslint.yml'}))
    .pipe(eslint.format())
    .pipe(babel({comments: false}))
    .pipe(gulp.dest(`${resultPath}js`));
});

gulp.task('js:prod', () => {
  return gulp.src(assets.javascripts)
    .pipe(babel({comments: false}))
    .pipe(concat('app.min.js'))
    .pipe(uglify())
    .pipe(header(license, {pkg}))
    .pipe(gulp.dest(`${resultPath}js`));
});

gulp.task('watch', () => {
  gulp.watch(assets.javascripts, ['javascript']);
  gulp.watch(watch.sass, ['sass']);
  gulp.watch(assets.images, ['images']);
});

gulp.task('default', ['clean', 'vendor', 'js', 'sass', 'images']);
gulp.task('watcher', ['default', 'watch']);
gulp.task('prod', ['clean', 'vendor', 'images', 'sass:prod', 'js']);
// gulp.task('prod', ['clean', 'vendor', 'images', 'sass:prod', 'js:prod']);
