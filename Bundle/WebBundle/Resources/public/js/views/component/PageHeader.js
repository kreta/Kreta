/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
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
