/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class FilterView extends Backbone.View {
  constructor(filters) {
    this.template = _.template($('#filter-template').html());
    this.filters = filters;

    this.callbacks = [];
    this.events = {
      'click .filter-item': 'filterClicked'
    };

    super();
  }

  render() {
    this.$el.html(this.template({'filters': this.filters}));

    return this;
  }

  // Callback register to notify event to external subscribers
  onFilterClicked(callback) {
    this.callbacks.push(callback);
  }

  filterClicked(ev) {
    var filters = this.selectFilterItem($(ev.currentTarget));

    this.callbacks.forEach((callback) => {
      callback(filters);
    });
  }

  selectFilterItem($item) {
    var itemGroup = $item.parent().index();

    $item.parent().find('a').removeClass('selected');
    $item.addClass('selected');

    this.filters[itemGroup].forEach((item) => {
      item.selected = false;
    });

    this.filters[itemGroup][$item.index()].selected = true;

    return this.filters;
  }
}
