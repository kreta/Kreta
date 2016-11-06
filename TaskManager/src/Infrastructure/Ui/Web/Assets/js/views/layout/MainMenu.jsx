/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/layout/_main-menu';

import ExitIcon from './../../../svg/exit';
import InboxIcon from './../../../svg/inbox';
import LogoIcon from './../../../svg/logo';
import ProjectsIcon from './../../../svg/projects';

import React from 'react';
import {Link} from 'react-router';
import { connect } from 'react-redux';
import Mousetrap from 'mousetrap';

import Config from './../../Config';
import Icon from './../component/Icon';
import Modal from './../component/Modal';
import ProjectList from './../page/project/List';
import Thumbnail from './../component/Thumbnail';
import MainMenuActions from '../../actions/MainMenu';

class MainMenu extends React.Component {
  componentDidMount() {
    Mousetrap.bind(Config.shortcuts.projectList, this.showProjectList.bind(this));
  }

  showProjectList() {
    this.props.dispatch(MainMenuActions.showProjects());
  }

  hideProjectsList() {
    this.props.dispatch(MainMenuActions.hideProjects());
  }

  render() {
    let profileWidget = '';
    if (this.props.profile) {
      profileWidget = (
        <Link className="main-menu__profile" to="/profile">
          <Thumbnail image={this.props.profile.photo.name}
                     text={`${this.props.profile.first_name} ${this.props.profile.last_name}`}/>
          <span className="main-menu__username">@{this.props.profile.username}</span>
        </Link>
      );
    }

    return (
      <nav className="main-menu">
        <Link className="main-menu__logo-container" to="/">
          <Icon className="main-menu__logo"
                glyph={LogoIcon}/>
        </Link>

        <div className="main-menu__actions">
          <Icon className="main-menu__action main-menu__action--green"
                glyph={ProjectsIcon}
                onClick={this.showProjectList.bind(this)}/>
          <a href="/logout">
            <Icon className="main-menu__action main-menu__action--red"
                  glyph={ExitIcon}/>
          </a>
        </div>
        <div className="main-menu__user">
          <div className="main-menu__notification">
            <Icon className="main-menu__action"
                  glyph={InboxIcon}/>
            <span className="main-menu__notification-bubble">0</span>
          </div>
          { profileWidget }
        </div>
        <Modal isOpen={this.props.mainMenu.projectsVisible}
               onRequestClose={this.hideProjectsList.bind(this)}>
          <ProjectList onProjectSelected={this.hideProjectsList.bind(this)} ref="projectList"/>
        </Modal>
      </nav>
    );
  }
}

const mapStateToProps = (state) => {
  return {
    profile: state.profile.profile,
    mainMenu: state.mainMenu
  };
};

export default connect(mapStateToProps)(MainMenu);
