/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {ProjectPreviewView} from '../../component/projectPreview';

export class ProjectListView extends Backbone.Marionette.CompositeView {
  constructor(options) {
    this.template = '#project-list-template';
    this.childView = ProjectPreviewView;
    this.childViewContainer = ".project-preview-list";
    this.collection = options.collection;
    this.childEvents = {
      'project:selected': function () {
        App.layout.getRegion('modal').closeModal();
      }
    };
    this.events = {
      'keyup': 'onKeyUp'
    };
    this.ui = {
      'project': '.project-preview-list'
    };
    this.selectedItem = 0;

    super(options);
  }

  onRender() {
    setTimeout(() => {
      this.focusSelectedItem();
    },100);

  }

  onKeyUp(ev) {
    if (ev.which == 40) { // Down
      if (this.selectedItem + 1 < this.ui.project.children().length) {
        this.selectedItem++;
        this.focusSelectedItem();
        return false;
      }

    }
    else if (ev.which == 38) { // Up
      if (this.selectedItem > 0) {
        this.selectedItem--;
        this.focusSelectedItem();
        return false;
      }
    }
  }

  focusSelectedItem() {
    this.ui.project.children().eq(this.selectedItem).focus();
  }
}
