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

class Filter extends React.Component {
  static propTypes = {
    onFiltersChanged: React.PropTypes.func.isRequired
  };

  triggerOnFilterSelected(group, filter) {
    this.props.filters[group].forEach((f) => {
      f.selected = false;
    });
    this.props.filters[group][filter].selected = true;
    this.props.onFiltersChanged(this.props.filters);
  }

  render() {
    var filtersEl = this.props.filters.map((filter, groupIndex) => {
      var groupFilters = filter.map((item, filterIndex) => {
        return (
          <a className={`filter-item ${ item.selected ? 'selected' : ''} `}
             onClick={this.triggerOnFilterSelected.bind(this, groupIndex, filterIndex)}>{item.title}</a>
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
}

export default Filter;
