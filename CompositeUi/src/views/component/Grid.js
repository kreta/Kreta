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

import './../../scss/components/_grid';

const
  Row = props => {
    let classList = `${props.className ? props.className : ''} row`;

    if (props.collapse) {
      classList = `${classList} row--collapse`;
    }

    if (props.center) {
      classList = `${classList} row--center`;
    }

    return (
      <div className={classList}>
        {props.children}
      </div>
    );
  },
  RowColumn = props => {
    let classList = `${props.className ? props.className : ''} row__column`;

    if (props.small) {
      classList = `${classList} row__column--small-${props.small}`;
    }

    if (props.medium) {
      classList = `${classList} row__column--medium-${props.medium}`;
    }

    if (props.large) {
      classList = `${classList} row__column--large-${props.large}`;
    }

    return (
      <div className={classList}>
        {props.children}
      </div>
    );
  };

export {
  Row,
  RowColumn
};
