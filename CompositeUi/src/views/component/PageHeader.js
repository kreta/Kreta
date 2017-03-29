/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_page-header.scss';

import React from 'react';

class PageHeader extends React.Component {
  static propTypes = {
    thumbnail: React.PropTypes.element,
    title: React.PropTypes.string
  };

  render() {
    const {thumbnail, title, children} = this.props;
    return (
      <div className="page-header">
        {thumbnail}
        <h2 className="page-header__title">{title}</h2>
        <div className="page-header__actions">
          {children}
        </div>
      </div>
    );
  }
}

export default PageHeader;
