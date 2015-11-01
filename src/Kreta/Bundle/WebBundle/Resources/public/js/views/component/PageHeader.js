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
import {Link} from 'react-router';

export default React.createClass({
  propTypes: {
    image: React.PropTypes.string,
    links: React.PropTypes.array,
    title: React.PropTypes.string
  },
  render() {
    const links = this.props.links.map((link) => {
      return (
        <Link className="page-header-link" to={link.href}>
          <i className={`fa fa-${link.icon}`}></i>
          {link.title}
        </Link>
      );
    });

    return (
      <div className="page-header">
        <div className="project-image" style={{background: '#ebebeb'}}></div>
        <h2 className="page-header-title">{this.props.title}</h2>
        <div>
          {links}
        </div>
      </div>
    );
  }
});
