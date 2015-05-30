/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class IssuePreviewView extends Backbone.View {
  constructor(options) {
    this.className = 'list-issue';

    this.template = _.template($('#list-issue-template').html());

    this.events = {
      'click .list-issue-title': 'showFullIssue'
    };

    super(options);

    App.vent.on('issue:highlight', (issueId) => {
      this.highlightIssue(issueId);
    });
  }

  render() {
    this.$el.html(this.template(this.model.toJSON()));
    return this;
  }

  showFullIssue() {
    App.router.base.navigate('/issue/' + this.model.id);
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
