/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class SelectorView extends Backbone.View {
  constructor ($el) {
    this.$el = $el;

    this.currentPos = 0;

    this.$selected = this.$el.children('span');
    this.$selected.focusin($.proxy(this.toggleSelector, this));
    this.$selected.focusout($.proxy(this.toggleSelector, this));
    this.$selected.keydown($.proxy(this.moveSelected, this));

    this.$selectables = this.$el.children('div');
    this.$selectableSpans = this.$selectables.find('span');
    this.$selectables.on(
      'mousedown', 'span', ($.proxy(this.optionClicked, this))
    );
  }

  setSelectables (selectables) {
    this.$selectables.html('');
    selectables.each((model) => {
      this.$selectables.append(
        '<span data-id="' + model.get('id') + '">' + model.toString() + '</span>'
      );
    });
    this.$selectableSpans = this.$selectables.find('span');
  }

  toggleSelector (ev) {
    $(ev.currentTarget).parent().toggleClass('visible');
    if (this.$el.hasClass('visible')) {
      this.currentPos = 0;
      this.highlightOption(0);
    }
  }

  highlightOption (index) {
    this.$selectableSpans.removeClass('selected');
    $(this.$selectableSpans.get(index)).addClass('selected');
  }

  moveSelected (ev) {
    if (ev.which === 38) { //Up
      if (this.currentPos > 0) {
        this.currentPos--;
        this.highlightOption(this.currentPos);
      }
      return;
    }
    if (ev.which === 40) { //Down
      this.currentPos++;
      this.highlightOption(this.currentPos);
      return;
    }
    if (ev.which === 13) {
      this.selectOption($(this.$selectableSpans.get(this.currentPos)));
    }
  }

  optionClicked (ev) {
    var $selected = $(ev.currentTarget);
    this.selectOption($selected);
  }

  selectOption ($selected) {
    var $input = $selected.parents('.kreta-selector').find('input');
    var $span = $selected.parents('.kreta-selector').children('span');
    $input.val($selected.attr('data-id')).trigger('change');
    $span.text($selected.text());
    $('[tabindex=' + (parseInt($span.attr('tabindex')) + 1) + ']').focus();
  }
}
