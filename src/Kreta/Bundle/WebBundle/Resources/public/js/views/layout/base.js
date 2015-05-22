/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {MainContentRegion} from '../region/mainContent';

export class BaseLayoutView extends Backbone.Marionette.LayoutView {
  constructor(options) {
    this.el = '.application';
    this.template = "#base-layout-view-template";
    this.regions = {
      'menu': '.menu-main',
      'left-aside': '.left-aside',
      'right-aside': '.right-aside',
      'content': new MainContentRegion()
    };
    super(options);
  }
}
