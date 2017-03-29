/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import React from 'react';

import './../../scss/components/_grid.scss';

const
  Row = props => {
    const {className, collapse, center, children} = props;

    let classList = `${className ? className : ''} row`;

    if (collapse) {
      classList = `${classList} row--collapsed`;
    }

    if (center) {
      classList = `${classList} row--centered`;
    }

    return (
      <div className={classList}>
        {children}
      </div>
    );
  },
  RowColumn = props => {
    const {className, small, medium, large, children} = props;

    let classList = `${className ? className : ''} row__column`;

    if (small) {
      classList = `${classList} row__column--small-${small}`;
    }

    if (medium) {
      classList = `${classList} row__column--medium-${medium}`;
    }

    if (large) {
      classList = `${classList} row__column--large-${large}`;
    }

    return (
      <div className={classList}>
        {children}
      </div>
    );
  };

export {
  Row,
  RowColumn
};
