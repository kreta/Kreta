/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class ProjectPreviewView extends Backbone.Marionette.ItemView {
  constructor(options) {
    this.className = 'project-preview';
    this.tagName = 'li';

    this.template = _.template($('#project-preview-template').html());

    this.events = {
      'keyup': 'onKeyUp',
      'mouseenter': 'onHover',
      'mouseenter .project-preview-shortcut': 'onShortcutHover',
      'click .project-preview-shortcut': 'onShortcutClick'
    };

    this.ui = {
      'shortcuts': '.project-preview-shortcut'
    };

    this.shortcuts = [{
      'icon': 'list',
      'method': $.proxy(this.showFullProject, this),
      'tooltip': 'Show full project'
    }, {
      'icon': 'add',
      'method': $.proxy(this.showNewTask, this),
      'tooltip': 'New task'
    }];
    this.selectedShortcut = 0;

    super(options);
  }

  onBeforeRender() {
    this.model.set('shortcuts', this.shortcuts)
  }

  onRender() {
    this.$el.attr('tabindex', '-1');
    this.updateSelectedShortcut();
  }

  onKeyUp(ev) {
    switch(ev.which) {
      case 37: { // Left
        if (this.selectedShortcut > 0) {
          this.selectedShortcut--;
          this.updateSelectedShortcut();
          return false;
        }
        break;
      }
      case 39: { // Right
        if (this.selectedShortcut + 1 < this.shortcuts.length) {
          this.selectedShortcut++;
          this.updateSelectedShortcut();
          return false;
        }
        break;
      }
      case 13: { // Enter
        this.shortcuts[this.selectedShortcut].method()
      }
      default: {
        break;
      }
    }
  }

  onHover() {
    this.$el.focus();
  }

  onShortcutHover(ev) {
    this.selectedShortcut = $(ev.currentTarget).index();
    this.updateSelectedShortcut();
  }

  onShortcutClick(ev) {
    this.shortcuts[$(ev.currentTarget).index()].method()
  }

  updateSelectedShortcut() {
    this.ui.shortcuts.removeClass('selected');
    this.ui.shortcuts.eq(this.selectedShortcut).addClass('selected');
  }

  showFullProject() {
    this.triggerMethod('project:selected');

    App.router.base.navigate('/project/' + this.model.id);
    App.controller.project.showAction(this.model);

    return false;
  }

  showNewTask() {
    this.triggerMethod('project:selected');

    App.router.base.navigate('/issue/new/' + this.model.id);
    App.controller.issue.newAction(this.model.id);
  }
}
