/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {FilterView} from '../../component/filter';
import {IssuePreviewView} from '../../component/issuePreview';

export class IssueListView extends Backbone.Marionette.CompositeView {
  initialize() {
    this.template = '#project-issues-template';
    this.childView = IssuePreviewView;
    this.childViewContainer = '.issues';

    this.events = {
      'click #project-settings-show': 'showSettings'
    };

    this.ui = {
      issues: '.issues',
      filter: '.filter'
    };

    this.highlightIndex = -1;

    Mousetrap.bind('up', $.proxy(this.highlightPrevious, this));

    Mousetrap.bind('down', $.proxy(this.highlightNext, this));

    this.loadFilters();

    this.model.on('sync', $.proxy(this.render, this));
  }

  onRender() {
    this.filterView = new FilterView(this.filters);
    this.filterView.onFilterClicked((filter) => {
      this.filterIssues(filter);
    });

    this.ui.filter.html(this.filterView.render().el);
  }

  loadFilters() {
    this.filters = [[
      {
        title: 'All',
        filter: 'assignee',
        value: '',
        selected: true
      }, {
        title: 'Assigned to me',
        filter: 'assignee',
        value: App.currentUser.get('id'),
        selected: false
      }
    ], [
      {
        title: 'All priorities',
        filter: 'priority',
        value: '',
        selected: true
      }
    ], [
      {
        title: 'All statuses',
        filter: 'status',
        value: '',
        selected: true
      }
    ]];

    this.render();
  }

  filterIssues(filters) {
    var data = {project: this.model.id};

    filters.forEach((filter) => {
      filter.forEach((item) => {
        if (item.selected) {
          data[item.filter] = item.value;
        }
      });
    });

    this.ui.issues.html('');
    this.collection.fetch({data: data, reset: true});
  }

  showSettings() {
    App.router.base.navigate('/project/' + this.model.id + '/settings');
    App.controller.project.settingsAction(this.model);
    return false;
  }

  highlightPrevious() {
    if(this.highlightIndex === 0) {
      return;
    }
    this.highlightIndex--;
    this.showHighlightedIssue();
    return false;
  }

  highlightNext() {
    if(this.highlightIndex >= this.collection.length - 1) {
      return;
    }
    this.highlightIndex++;
    this.showHighlightedIssue();
    return false;
  }

  showHighlightedIssue() {
    var issue = this.collection.at(this.highlightIndex);
    App.vent.trigger('issue:highlight', issue.get('id'));
    App.controller.issue.showAction(issue);
  }

  onDestroy() {
    Mousetrap.unbind('up', $.proxy(this.highlightPrevious, this));
    Mousetrap.unbind('down', $.proxy(this.highlightNext, this));
  }
}
