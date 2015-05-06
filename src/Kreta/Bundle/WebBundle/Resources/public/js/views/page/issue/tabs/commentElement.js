/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class CommentElement extends Backbone.View {
  constructor (options) {
    this.className = 'user-interaction';

    this.template = _.template($('#user-interaction-template').html());
    super(options);
  }

  render () {
    this.$el.html(this.template(this.model.toJSON()));
    return this;
  }
}