/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {IssueCollection} from '../../collections/issue';
import {MiniIssueView} from './miniIssue';

export class MiniIssueList extends Backbone.View {
  constructor (options) {
    this.template = _.template($('#kreta-project-issues-template').html());

    this.projectId = options.projectId;

    this.issues = new IssueCollection();
    this.issues.fetch({data: {projects: this.projectId}});

    this.events = {
      "click .filter a": "filterClicked"
    };

    super(options);

    this.render();

    this.listenTo(this.issues, 'add', this.addOne);
    this.listenTo(this.issues, 'reset', this.addAll);
  }

  render () {
    this.$el.html(this.template({}));
    this.$issues = this.$el.find('.issues');
    this.$filter = this.$el.find('.filter');

    return this;
  }

  addAll () {
    this.$issues.html('');
    this.issues.each(this.addOne, this);
  }

  addOne (model) {
    var view = new MiniIssueView({model});
    this.$issues.append(view.render().el);
  }

  filterClicked(ev)
  {
    $(ev.currentTarget).parent().find('a').removeClass('selected');
    $(ev.currentTarget).addClass('selected');
    this.filterIssues();
  }

  filterIssues() {
    var filter = {};
    this.$filter.children().each(function() {
      var $selected = $(this).find('.selected');
      if($selected.attr('data-value')) {
        filter[$selected.attr('data-filter')] = $selected.attr('data-value');
      }
    });
    var data = {projects: this.projectId};
    jQuery.extend(data, filter);
    this.issues.fetch({data: data, reset: true})
    this.$issues.html('');
  }
}
