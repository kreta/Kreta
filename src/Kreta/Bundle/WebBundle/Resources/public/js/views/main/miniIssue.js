/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class MiniIssueView extends Backbone.View {
  constructor (options) {
    this.className = 'kreta-list-issue';

    this.template = _.template($('#kreta-mini-issue-template').html());
    super(options);
  }

  render () {
    this.$el.html(this.template(this.model.toJSON()));
    return this;
  }
}
