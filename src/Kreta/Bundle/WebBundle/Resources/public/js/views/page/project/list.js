/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {ProjectCollection} from '../../../collections/project';
import {ProjectPreviewView} from '../../component/projectPreview';
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
    this.$el.html($('#project-list-template').html());
    this.$projects = this.$el.find('.project-list');
    return this;
  }

  addOne (project) {
    var view = new ProjectPreviewView({model: project});
    this.$projects.append(view.render().el);
  }

  addAll () {
    this.$projects.html('');
    this.projects.each(this.addOne, this);
  }
}
