/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {IssueController} from '../../controllers/issue';

export class IssuePreviewView extends Backbone.View {
  constructor(options) {
    this.className = 'list-issue';

    this.template = _.template($('#list-issue-template').html());

    this.events = {
      'click .list-issue-title': 'showFullIssue'
    };

    super(options);

    this.listenTo(Backbone, 'issue:highlight', this.highlightIssue);
  }

  render() {
    this.$el.html(this.template(this.model.toJSON()));
    return this;
  }

  showFullIssue() {
    App.router.navigate('/issue/' + this.model.id);
    var controller = new IssueController();
    controller.showAction(this.model);
  }

  highlightIssue(issueId) {
    if (issueId === this.model.id) {
      this.$el.addClass('highlight');
    } else {
      this.$el.removeClass('highlight');
    }
  }
}
