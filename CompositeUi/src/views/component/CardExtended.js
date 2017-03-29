/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_card-extended.scss';

import React from 'react';

class CardExtended extends React.Component {
  static propTypes = {
    subtitle: React.PropTypes.string,
    thumbnail: React.PropTypes.element,
    title: React.PropTypes.string.isRequired
  };

  thumbnail() {
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

  subtitle() {
    const {subtitle} = this.props;

    if (subtitle) {
      return (
        <span className="card-extended__sub-header">
          {subtitle}
        </span>
      );
    }

    return '';
  }

  render() {
    const {title, children} = this.props;

    return (
      <div className="card-extended">
        {this.thumbnail()}
        <div className="card-extended__container">
          <span className="card-extended__header">
            {title}
          </span>
          {this.subtitle()}
        </div>
        <div className="card-extended__actions">
          {children}
        </div>
      </div>
    );
  }
}

export default CardExtended;
