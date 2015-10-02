/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {React} from 'react';

export default React.createClass({
  getInitialState() {
    return {
      selectedShortcut: 0
    }
  },
  getDefaultProps() {
    return {
      shortcuts: [{
        'icon': 'list',
        'method': $.proxy(this.showFullProject, this),
        'tooltip': 'Show full project'
      }, {
        'icon': 'add',
        'method': $.proxy(this.showNewTask, this),
        'tooltip': 'New task'
      }]
    };
  },
  onKeyUp(ev) {
    switch (ev.which) {
      case 37:
      { // Left
        if (this.selectedShortcut > 0) {
          this.selectedShortcut--;
          this.updateSelectedShortcut();
          return false;
        }
        break;
      }
      case 39:
      { // Right
        if (this.selectedShortcut + 1 < this.shortcuts.length) {
          this.selectedShortcut++;
          this.updateSelectedShortcut();
          return false;
        }
        break;
      }
      case 13:
      { // Enter
        this.shortcuts[this.selectedShortcut].method();
        return false;
      }
      default:
      {
        return true;
      }
    }
  },
  showFullProject() {
    this.triggerMethod('project:selected');
    App.router.base.navigate(`/project/${this.model.id}`);
    App.controller.project.showAction(this.model);

    return false;
  },

  showNewTask() {
    this.triggerMethod('project:selected');
    App.router.base.navigate(`/issue/new/${this.model.id}`);
    App.controller.issue.newAction(this.model.id);
  },
  render() {
    var shortcutItems = this.props.shortcuts.map((shortcut, index) => {
      return (
        <img className={`project-preview__shortcut
              ${ index === this.state.selectedShortcut ?
                ' project-preview__shortcut--selected' : ''}`}
             onClick={shortcut.method}
             onHover={this.setState({selectedShortcut: index})}
             onKeyUp={this.onKeyUp}
             src={`/bundles/kretaweb/svg/${shortcut.icon}.svg`}/>
      );
    });
    return (
      <div>
        <span class="project-preview__title" href="/project/<%= id %>">
          {this.props.project.get('name')}
        </span>

        <div class="project-preview__shortcuts">
          {shortcutItems}
        </div>
      </div>
    );
  }
});
/*constructor(options = {}) {
 _.defaults(options, {
 className: 'project-preview',
 tagName: 'li',
 template: _.template($('#project-preview-template').html()),
 events: {
 'keyup': 'onKeyUp',
 'mouseenter': 'onHover',
 'mouseenter .project-preview__shortcut': 'onShortcutHover',
 'click .project-preview__shortcut': 'onShortcutClick'
 }
 });
 super(options);

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
 }

 ui() {
 return {
 'shortcuts': '.project-preview__shortcut'
 };
 }

 onBeforeRender() {
 this.model.set('shortcuts', this.shortcuts);
 }

 onRender() {
 this.$el.attr('tabindex', '-1');
 this.updateSelectedShortcut();
 }

 onKeyUp(ev) {
 switch (ev.which) {
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
 this.shortcuts[this.selectedShortcut].method();
 return false;
 }
 default: {
 return true;
 }
 }
 }

 onShortcutHover(ev) {
 this.selectedShortcut = $(ev.currentTarget).index();
 this.updateSelectedShortcut();
 }

 onShortcutClick(ev) {
 this.shortcuts[$(ev.currentTarget).index()].method();
 }

 updateSelectedShortcut() {
 this.ui.shortcuts.removeClass('selected');
 this.ui.shortcuts.eq(this.selectedShortcut).addClass('selected');
 }

 showFullProject() {
 this.triggerMethod('project:selected');
 App.router.base.navigate(`/project/${this.model.id}`);
 App.controller.project.showAction(this.model);

 return false;
 }

 showNewTask() {
 this.triggerMethod('project:selected');
 App.router.base.navigate(`/issue/new/${this.model.id}`);
 App.controller.issue.newAction(this.model.id);
 }*/
