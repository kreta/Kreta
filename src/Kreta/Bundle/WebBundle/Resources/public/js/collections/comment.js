/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {Comment} from '../models/comment';

export class CommentCollection extends Backbone.Collection {
  constructor (models, options) {
    this.model = Comment;
    super(models, options);
  }

  setIssue (issueId) {
    this.url = App.config.getBaseUrl() + '/issues/' + issueId + '/comments';
    return this;
  }
}
