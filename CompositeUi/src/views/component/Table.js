/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_table.scss';

import React from 'react';

class Table extends React.Component {
  static propTypes = {
    columns: React.PropTypes.number.isRequired,
    headers: React.PropTypes.arrayOf(React.PropTypes.string),
    items: React.PropTypes.arrayOf(React.PropTypes.element).isRequired,
  };

  columnWith() {
    const {columns} = this.props;

    if (window.innerWidth < 650) {
      return '100%';
    }

    return `calc(${100 / columns}% - 5px)`;
  }

  fixedLastRow(tableItems) {
    const {columns, items} = this.props,
      exceededItems = items.length % columns;

    for (let i = 0; i < exceededItems; i++) {
      tableItems.push(
        <div
          className="table__item table__item--hidden"
          key={items.length + i}
          style={{flexBasis: this.columnWith()}}
        />,
      );
    }

    return tableItems;
  }

  header(index) {
    const {headers} = this.props;

    if (!headers) {
      return;
    }

    return (
      <h4
        className="table__header"
        key={index}
        style={{flexBasis: this.columnWith()}}
      >
        {headers[index]}
      </h4>
    );
  }

  content(index) {
    const {items} = this.props;

    return (
      <div className="table__content">
        {items[index]}
      </div>
    );
  }

  items() {
    const {items} = this.props;

    return this.fixedLastRow(
      items.map((item, index) =>
        <div
          className="table__item"
          key={index}
          style={{flexBasis: this.columnWith()}}
        >
          {this.header(index)}
          {this.content(index)}
        </div>,
      ),
    );
  }

  render() {
    return (
      <div className="table">
        {this.items()}
      </div>
    );
  }
}

export default Table;
