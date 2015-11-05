/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/components/_page-header';

import classnames from 'classnames';
import {Link} from 'react-router';
import React from 'react';

import Icon from './Icon';

class PageHeader extends React.Component {
  static propTypes = {
    image: React.PropTypes.string,
    links: React.PropTypes.array,
    title: React.PropTypes.string
  };

  render() {
    var links = this.props.links.map((link) => {
      const classes = classnames('page-header__icon', {
        'page-header__icon--green': link.color === 'green'
      });
      return (
        <Link className="page-header__link" to={link.href}>
          <Icon className={classes}
                glyph={link.icon}/>
          {link.title}
        </Link>
      );
    });

    return (
      <div className="page-header">
        <div className="project-image" style={{background: '#ebebeb'}}></div>
        <h2 className="page-header__title">{this.props.title}</h2>
        <div>
          {links}
        </div>
      </div>
    );
  }
}

export default PageHeader;
