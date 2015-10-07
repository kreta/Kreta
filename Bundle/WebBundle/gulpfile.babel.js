/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import gulp from 'gulp';
import scsslint from 'gulp-scss-lint';

var knownOptions = {string: 'from', default: {from: ''}},
  options = minimist(process.argv.slice(2), knownOptions),
  fromVendorPath = options.from === 'vendor' ? '/../' : '/';

const BASE_PATH = `./../../../..${fromVendorPath}web/bundles/kretaweb/`,
  RESULT_PATH = `./../../../..${fromVendorPath}web/`,
  SASS = `${BASE_PATH}scss/**`;

gulp.task('scss-lint', () => {
  return gulp.src(SASS)
    .pipe(scsslint());
});
