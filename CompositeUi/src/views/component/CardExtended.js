/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_card-extended';

import React from 'react';

class CardExtended extends React.Component {
  static propTypes = {
    thumbnail: React.PropTypes.element
  };

  getThumbnail() {
    const {thumbnail} = this.props;

    if (thumbnail) {
      return (
        <div className="card-extended__thumbnail">
          {thumbnail}
        </div>
      );
    }

    return '';
  }

  render() {
    const {title, subtitle, children} = this.props;

    return (
      <div className="card-extended">
        {this.getThumbnail()}
        <div className="card-extended__container">
          <span className="card-extended__header">
            {title}
          </span>
          <span className="card-extended__sub-header">
            {subtitle}
          </span>
        </div>
        <div className="card-extended__actions">
          {children}
        </div>
      </div>
    );
  }
}

export default CardExtended;
