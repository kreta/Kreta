/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class SelectorView extends Backbone.View {
  constructor($el, options) {
    this.$el = $el;

    options = $.extend({
      onSelect: null
    }, options);

    this.$el.select2();
    this.$el.on('change', options.onSelect);

  }

  setSelectables(selectables) {
    this.selectables = selectables;
    this.$el.html('');
    this.selectables.forEach((model) => {
      this.$el.append(
        `<option value="${model.get('id')}">${model.toString()}</option>`
      );
    });
    this.openOnFocus();

    //Fixes issue when selecting first item, select2 doesn`t detect change otherwise
    setTimeout(() => {
      this.$el.select2('val', null);
    }, 50);

  }

  openOnFocus() {
    setTimeout(() => {
      this.$el.next('.select2').find(".select2-selection").on('focus', () => {
        this.$el.select2('open');
      });
    });
  }

  select2(method) {
    this.$el.select2(method);
  }
}
