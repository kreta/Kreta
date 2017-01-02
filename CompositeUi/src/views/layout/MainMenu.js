/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/layout/_main-menu';

import ExitIcon from './../../svg/exit';
import InboxIcon from './../../svg/inbox';
import LogoIcon from './../../svg/logo';
import ProjectsIcon from './../../svg/projects';

import React from 'react';
import {Link} from 'react-router';
import {connect} from 'react-redux';
import Mousetrap from 'mousetrap';

import Config from './../../Config';
import Icon from './../component/Icon';
import MainMenuActions from './../../actions/MainMenu';
import Modal from './../component/Modal';
import ProjectList from './../page/project/List';
import Thumbnail from './../component/Thumbnail';
import UserActions from './../../actions/User';

@connect(state => ({profile: state.profile.profile, mainMenu: state.mainMenu}))
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

  logout() {
    this.props.dispatch(UserActions.logout());
  }

  render() {
    let profileWidget = '';
    if (this.props.profile) {
      profileWidget = (
        <Link className="main-menu__profile" to="/profile">
          <Thumbnail
            image={this.props.profile.photo.name}
            text={`${this.props.profile.first_name} ${this.props.profile.last_name}`}
          />
          <span className="main-menu__username">@{this.props.profile.username}</span>
        </Link>
      );
    }

    return (
      <nav className="main-menu">
        <Link className="main-menu__logo-container" to="/">
          <Icon color="white" glyph={LogoIcon} size="expand"/>
        </Link>
        <div className="main-menu__actions">
          <div className="main-menu__action">
            <Icon color="green" glyph={ProjectsIcon} onClick={this.showProjectList.bind(this)} size="medium"/>
          </div>
          <div className="main-menu__action">
            <Icon color="red" glyph={ExitIcon} onClick={this.logout.bind(this)} size="medium"/>
          </div>
        </div>
        <div className="main-menu__user">
          <div className="main-menu__notification">
            <Icon color="white" glyph={InboxIcon} size="medium"/>
            <span className="main-menu__notification-bubble">0</span>
          </div>
          {profileWidget}
        </div>
        <Modal
          isOpen={this.props.mainMenu.projectsVisible}
          onRequestClose={this.hideProjectsList.bind(this)}
        >
          <ProjectList onProjectSelected={this.hideProjectsList.bind(this)} ref="projectList"/>
        </Modal>
      </nav>
    );
  }
}

export default MainMenu;
