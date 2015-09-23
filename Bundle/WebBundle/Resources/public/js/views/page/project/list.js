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
    this.events = {
      'keyup': 'onKeyUp',
      'mouseenter @ui.projectPreview': 'onMouseEnter'
    };
    this.ui = {
      'project': '.project-preview__list',
      'projectPreview': '.project-preview',
      'filter': '.project-list__filter'
    };
    this.selectedItem = 0;

    super(options);
  }

  onRender() {
    setTimeout(() => {
      this.focusSelectedItem();
      this.ui.filter.focus();
    }, 100);
  }

  onKeyUp(ev) {
    if (ev.which === 40) { // Down
      if (this.selectedItem + 1 < this.ui.project.children().length) {
        this.selectedItem++;
        this.focusSelectedItem();
        this.centerListScroll();

        return false;
      }

    } else if (ev.which === 38) { // Up
      if (this.selectedItem > 0) {
        this.selectedItem--;
        this.focusSelectedItem();
        this.centerListScroll();

        return false;
      }
    } else {
      // Delegate event handling to selected view
      if (this.children.length > 0 &&
        !this.children.findByIndex(this.selectedItem).onKeyUp(ev)) {
        return false;
      }

      this.collection.reset(
        App.collection.project.filterByName(this.ui.filter.val())
      );
      this.selectedItem = 0;
      this.focusSelectedItem();
    }
  }

  onMouseEnter(ev) {
    this.selectedItem = $(ev.currentTarget).index();
    this.focusSelectedItem();
  }

  focusSelectedItem() {
    this.ui.project.children().removeClass('project-preview--selected');
    this.ui.project.children().eq(this.selectedItem)
      .addClass('project-preview--selected');
  }

  centerListScroll() {
    this.ui.project.scrollTop(this.selectedItem * 60 - 60 * 2);
  }
}
