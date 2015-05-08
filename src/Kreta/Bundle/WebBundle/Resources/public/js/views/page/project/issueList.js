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

export class IssueListView extends Backbone.View {
  constructor(options) {
    this.template = _.template($('#kreta-project-issues-template').html());

    this.projectId = options.projectId;

    this.issues = new IssueCollection();
    this.issues.fetch({data: {project: this.projectId}});

    this.events = {
      "click .filter a": "filterClicked"
    };

    super(options);

    this.loadFilters();

    this.listenTo(this.issues, 'add', this.addOne);
    this.listenTo(this.issues, 'reset', this.addAll);
    this.listenTo(App.currentUser, 'change', this.loadFilters);
    this.listenTo(Backbone, 'issue:highlight', this.highlightIssue);
  }

  render() {
    this.$el.html(this.template({}));
    this.$issues = this.$el.find('.issues');
    this.$filter = this.$el.find('.filter');

    var html = '';
    this.filters.forEach((filter) => {
      var selected = true;
      html += '<div>';
      for (title in filter) {
        html += $('<a></a>')
          .attr('data-filter', filter[title].filter)
          .attr('data-value', filter[title].value)
          .text(title)
          .addClass(selected ? 'selected' : '')
          .get(0).outerHTML;
        selected = false;
      }
      html += '</div>';
    });

    this.$filter.html(html);

    return this;
  }

  loadFilters() {
    this.filters = [{
      'All': {
        filter: 'assignee',
        value: ''
      },
      'Assigned to me': {
        filter: 'assignee',
        value: App.currentUser.get('id')
      }
    }, {
      'All priorities': {
        'filter': 'priority',
        'value': ''
      }
    }, {
      'All statuses': {
        'filter': 'status',
        'value': ''
      }
    }];

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

  filterClicked(ev) {
    $(ev.currentTarget).parent().find('a').removeClass('selected');
    $(ev.currentTarget).addClass('selected');
    this.filterIssues();
  }

  filterIssues() {
    var filter = {};
    this.$filter.children().each(function () {
      var $selected = $(this).find('.selected');
      if ($selected.attr('data-value')) {
        filter[$selected.attr('data-filter')] = $selected.attr('data-value');
      }
    });
    var data = {projects: this.projectId};
    jQuery.extend(data, filter);
    this.issues.fetch({data: data, reset: true});
    this.$issues.html('');
  }

  highlightIssue(issueId) {
    var index = this.issues.findIndexById(issueId);

    this.$issues.children().removeClass('highlight');

    if(index >= 0) {
      $(this.$issues.children().get(index)).addClass('highlight');
    }
  }
}
