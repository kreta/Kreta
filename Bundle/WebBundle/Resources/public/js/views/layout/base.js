/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {AsideRegion} from '../region/aside';
import {MainContentRegion} from '../region/mainContent';
import {ModalRegion} from '../region/modal';

export class BaseLayoutView extends Backbone.Marionette.LayoutView {
  constructor(options = {}) {
    _.defaults(options, {
      el: '.application',
      template: '#base-layout-view-template',
      regions: {
        'menu': '.menu-main',
        'left-aside': new AsideRegion({position: 'left'}),
        'right-aside': new AsideRegion({position: 'right'}),
        'content': new MainContentRegion(),
        'notification': '.notification-container',
        'modal': new ModalRegion()
      }
    });
    super(options);
  }
}
