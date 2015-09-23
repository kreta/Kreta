/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {ProjectPreviewView} from '../../component/projectPreview';
import {ProjectCollection} from '../../../collections/project';
import {NavigableCollectionBehavior}
  from '../../../behaviours/navigableCollection';

export class ProjectListView extends Backbone.Marionette.CompositeView {
  constructor(options) {
    this.template = '#project-list-template';
    this.childView = ProjectPreviewView;
    this.childViewContainer = '.project-preview__list';
    this.collection = new ProjectCollection();
    this.collection.reset(App.collection.project.toJSON());
    this.childEvents = {
      'project:selected': () => {
        App.layout.getRegion('modal').closeModal();
      }
    };

    this.behaviors = {
      navigableCollection: {
        behaviorClass: NavigableCollectionBehavior,
        originalCollection: App.collection.project,
        childViewEl: '.project-preview',
        childHighlightClass: 'project-preview--selected'
      }
    };

    super(options);
  }
}
