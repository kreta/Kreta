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

    this.issues = new IssueCollection();
    this.issues.fetch({data: {projects: options.projectId}});

    super(options);

    this.render();

    this.listenTo(this.issues, 'add', this.addOne);
    this.listenTo(this.issues, 'reset', this.addAll);
  }

  render () {
    this.$el.html(this.template({}));
    this.$issues = this.$el.find('.issues');

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
}
