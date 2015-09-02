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

    super(options);
  }
}
