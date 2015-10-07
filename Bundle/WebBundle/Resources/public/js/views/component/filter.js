/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import React from 'react';

export default React.createClass({
  propTypes: {
    onFilterSelected: React.PropTypes.func.isRequired
  },
  selectFilterItem($item) {
    var itemGroup = $item.parent().index();

    $item.parent().find('a').removeClass('selected');
    $item.addClass('selected');

    this.props.filters[itemGroup].forEach((item) => {
      item.selected = false;
    });

    this.props.filters[itemGroup][$item.index()].selected = true;

    return this.props.filters;
  },
  filterSelected(ev) {
    this.selectFilterItem($(ev.currentTarget));
    this.props.onFilterSelected(this.props.filters);
  },
  render() {
    var filtersEl = this.props.filters.map((filter) => {
      var groupFilters = filter.map((item) => {
        return (
          <a className={`filter-item ${ item.selected ? 'selected' : ''} `}
          data-filter={ item.filter }
          data-value={ item.value }
          onClick={this.filterSelected}
          >{item.title}</a>
        );
      });
      return <div className="filter-group">{groupFilters}</div>;
    });

    return (
      <div className="filter">
        {filtersEl}
      </div>
    );
  }
});
