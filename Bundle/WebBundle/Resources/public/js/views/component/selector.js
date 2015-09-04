/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class SelectorView extends Backbone.View {
  constructor($el) {
    this.$el = $el;
    this.onOptionSelectedCallback = null;

    this.$el.select2();
    /*this.$el.siblings('.select2').find(".select2-selection").on('focus', () => {
      $(this).select2('open');
    });*/
  }

  setSelectables(selectables) {
    this.selectables = selectables;
    this.$el.html('');
    this.selectables.forEach((model) => {
      this.$el.append(
        `<option value="${model.get('id')}">${model.toString()}</option>`
      );
    });
  }

  onOptionSelected(callback) {
    this.$el.on('change', callback)
  }

  select2(method) {
    this.$el.select2(method);
  }
}
