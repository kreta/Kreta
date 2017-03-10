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
import classnames from 'classnames';

import './../../scss/components/_selector-option';

class SelectorOption extends React.Component {
  static propTypes = {
    alignLeft: React.PropTypes.bool,
    label: React.PropTypes.string,
    text: React.PropTypes.string.isRequired,
    thumbnail: React.PropTypes.element,
    value: React.PropTypes.string.isRequired
  };

  render() {
    const
      {alignLeft, label, text, thumbnail, ...otherProps} = this.props,
      classes = classnames(
      'selector-option', {
        'selector-option--left': alignLeft,
      }
    );

    let thumbnailEl = '';
    if (thumbnail) {
      thumbnailEl = (
        <div className="selector-option__thumbnail">
          {thumbnail}
        </div>
      );
    }

    return (
      <div className={classes} {...otherProps}>
        {thumbnailEl}
        <span className="selector-option__label">{label}</span>
        <span className="selector-option__value">{text}</span>
      </div>
    );
  }
}

export default SelectorOption;
