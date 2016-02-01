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

import Button from './Button';
import Icon from './Icon';

class PageHeader extends React.Component {
  static propTypes = {
    buttons: React.PropTypes.array,
    image: React.PropTypes.string,
    links: React.PropTypes.array,
    title: React.PropTypes.string
  };

  renderLinks() {
    return this.props.links.map((link) => {
      const classes = classnames('page-header__link-icon', {
        'page-header__link-icon--green': link.color === 'green'
      });
      return (
        <Link className="page-header__link" to={link.href}>
          <Icon className={classes}
          glyph={link.icon}/>
          {link.title}
        </Link>
      );
    });
  }

  renderButtons() {
    return this.props.buttons.map((button) => {
      return (
        <Link className="page-header__link" to={button.href}>
          <Button color="green">
            {button.title}
          </Button>
        </Link>
      );
    });
  }

  render() {
    let image = <div className="page-header__image"></div>;
    if(this.props.image) {
      image = <img className="page-header__image" src={this.props.image}/>
    }
    return (
      <div className="page-header">
        {image}
        <h2 className="page-header__title">{this.props.title}</h2>
        <div className="page-header__actions">
          {this.renderLinks()}
          {this.renderButtons()}
        </div>
      </div>
    );
  }
}

export default PageHeader;
