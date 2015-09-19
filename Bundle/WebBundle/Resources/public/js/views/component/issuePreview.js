/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class IssuePreviewView extends Backbone.Marionette.ItemView {
  constructor(options) {
    this.className = 'list-issue';

    this.template = _.template($('#list-issue-template').html());

    this.events = {
      'click .list-issue-title': 'showFullIssue'
    };

    super(options);

    this.listenTo(App.vent, 'issue:highlight', (issueId) => {
      this.highlightIssue(issueId);
    });

    this.listenTo(App.vent, 'issue:updated', (issue) => {
      if (this.model.id === issue.id) {
        this.model.set(issue);
        this.render();
      }
    });
  }

  showFullIssue() {
    App.controller.issue.showAction(this.model);

    return false;
  }

  highlightIssue(issueId) {
    if (issueId === this.model.id) {
      this.$el.addClass('highlight');
    } else {
      this.$el.removeClass('highlight');
    }
  }
}
