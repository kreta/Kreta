/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_thumbnail.scss';

import React from 'react';

class Thumbnail extends React.Component {
  static propTypes = {
    image: React.PropTypes.string,
    text: React.PropTypes.string.isRequired,
  };

  render() {
    if (this.props.image) {
      return <img className="thumbnail" src={this.props.image} />;
    }

    const spacePosition = this.props.text.indexOf(' ');
    let resultChar = '';

    if (spacePosition === -1) {
      resultChar = this.props.text.substring(0, 2);
    } else {
      resultChar = `${this.props.text.charAt(0)}${this.props.text.charAt(
        spacePosition + 1,
      )}`;
    }

    return (
      <div className="thumbnail thumbnail--has-char">
        <span className="thumbnail__char">
          {resultChar.toUpperCase()}
        </span>
      </div>
    );
  }
}

export default Thumbnail;
