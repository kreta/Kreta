/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import '../../scss/components/_filter.scss';

import React from 'react';

class Filter extends React.Component {
  static propTypes = {
    filters: React.PropTypes.array.isRequired,
    onFilterSelected: React.PropTypes.func.isRequired
  };

  index(element) {
    return [...element.parentNode.children].indexOf(element);
  }

  selectFilterItem(item) {
    const itemGroup = this.index(item.parentElement);

    item.parentNode.querySelector('a').classList.remove('selected');
    item.classList.add('selected');

    this.props.filters[itemGroup].forEach((filter) => {
      filter.selected = false;
    });

    this.props.filters[itemGroup][this.index(item)].selected = true;

    return this.props.filters;
  }

  filterSelected(event) {
    this.selectFilterItem(event.currentTarget);
    this.props.onFilterSelected(this.props.filters);
  }

  render() {
    const filtersEl = this.props.filters.map((filter, index) => {
      const groupFilters = filter.map((item, index2) => (
        <a className={`filter-item${item.selected ? ' selected ' : ' '}`}
           data-filter={item.filter}
           data-value={item.value}
           key={index2}
           onClick={this.filterSelected.bind(this)}>{item.title}</a>
      ));

      return (
        <div className="filter-group" key={index}>
          {groupFilters}
        </div>
      );
    });

    return (
      <div className="filter">
        {filtersEl}
      </div>
    );
  }
}

export default Filter;
