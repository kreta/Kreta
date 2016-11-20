/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import '../../../scss/components/_filter.scss';

import React from 'react';
import $ from 'jquery';

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
             onClick={this.filterSelected}>{item.title}</a>
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
