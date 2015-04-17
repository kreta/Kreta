/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {ProjectCollection} from '../../../collections/project';
import {AsideView} from '../../layout/aside';

export class ProjectListView extends AsideView {
  constructor () {
    super();

    this.projects = new ProjectCollection();
    this.projects.fetch();

    this.listenTo(this.projects, 'add', this.addOne);
    this.listenTo(this.projects, 'reset', this.addAll);

    this.render();

    this.$container.append(this.$el);
  }

  render () {
    var ul = '<span class="kreta-sort-by">Sort by <strong>priority</strong></span>' +
      '<ul class="project-list">';
    ul += '</ul>';
    this.$el.html(ul);
    this.$projects = this.$el.find('.project-list');
    return this;
  }

  addOne (project) {
    var ul = '<li><a href="/project/' + project.get('id') + '">' + project.get('short_name');
    if (project.progress !== undefined) {
      ul += '<span>progress ' + project.progress + '%</span>';
    }
    ul += '</a></li>';
    this.$projects.append(ul);
  }

  addAll () {
    this.$projects.html('');
    this.projects.each(this.addOne, this);
  }
}
