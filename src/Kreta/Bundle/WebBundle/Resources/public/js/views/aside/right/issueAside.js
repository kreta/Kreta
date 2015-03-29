/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {Issue} from '../../../models/issue';

export class IssueAsideView extends Backbone.View {
  constructor (options) {
    this.id = 'issue-details';

    this.template = _.template($('#issue-details-template').html());

    super();
    this.model = new Issue({id: options.id});
    this.model.fetch();

    this.model.on('sync', this.render, this);
  }

  render () {
    this.$el.html(this.template(this.model.toJSON()));
    return this;
  }
}