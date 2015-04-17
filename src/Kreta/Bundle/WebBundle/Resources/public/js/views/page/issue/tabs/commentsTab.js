/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {CommentElement} from './commentElement';
import {CommentCollection} from '../../../../collections/comment';

export class CommentsTab extends Backbone.View {
  constructor (options) {
    this.className = 'issue-tab-content';

    this.comments = new CommentCollection();
    this.comments.setIssue(options.issueId);
    this.comments.fetch();

    this.listenTo(this.comments, 'add', this.addOne);
    this.listenTo(this.comments, 'reset', this.addAll);

    super(options);
  }

  render() {
    return this;
  }

  addAll () {
    this.$el.html('');
    this.comments.each(this.addOne, this);
  }

  addOne (model) {
    var view = new CommentElement({model});
    this.$el.append(view.render().el);
  }
}