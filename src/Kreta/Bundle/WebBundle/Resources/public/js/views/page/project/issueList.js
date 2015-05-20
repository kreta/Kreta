/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {IssueCollection} from '../../../collections/issue';
import {IssuePreviewView} from '../../component/issuePreview';
import {FilterView} from '../../component/filter';
import {Project} from '../../../models/project';

export class IssueListView extends Backbone.View {
  constructor(options) {
    this.template = _.template($('#project-issues-template').html());

    this.events = {
      'click #project-settings-show': 'showSettings'
    };

    super(options);

    this.issues = new IssueCollection();
    this.issues.fetch({data: {project: this.model.id}});

    this.loadFilters();
    this.render();

    this.model.on('sync', this.render, this);
    this.listenTo(this.issues, 'add', this.addOne);
    this.listenTo(this.issues, 'reset', this.addAll);
    this.listenTo(App.currentUser, 'change', this.loadFilters);
  }

  render() {
    this.$el.html(this.template(this.model.toJSON()));
    this.$issues = this.$el.find('.issues');
    this.$filter = this.$el.find('.filter');

    this.filterView = new FilterView(this.filters);
    this.filterView.onFilterClicked((filter) => {
      this.filterIssues(filter);
    });

    this.$filter.html(this.filterView.render().el);

    return this;
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

  addAll() {
    this.$issues.html('');
    this.issues.each(this.addOne, this);
  }

  addOne(model) {
    var view = new IssuePreviewView({model});
    this.$issues.append(view.render().el);
  }

  filterIssues(filters) {
    var data = {project: this.projectId};

    filters.forEach((filter) => {
      filter.forEach((item) => {
        if(item.selected) {
          data[item.filter] = item.value;
        }
      });
    });

    this.issues.fetch({data: data, reset: true});
    this.$issues.html('');
  }

  showSettings(ev) {
    ev.preventDefault();
    App.router.navigate('/project/' + this.model.id + '/settings');
    App.controller.project.settingsAction(this.model);
    return false;
  }
}
