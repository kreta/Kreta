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
import UserImage from './../component/UserImage';
import ActionTypes from '../../constants/ActionTypes';

class MainMenu extends React.Component {
  componentDidMount() {
    Mousetrap.bind(Config.shortcuts.projectList, this.showProjectList.bind(this));
  }

  showProjectList() {
    this.refs.projectListModal.openModal();
    setTimeout(() => {
      this.refs.projectList.focus();
    }, 0);
  }

  hideProjectList() {
    this.refs.projectListModal.closeModal();
  }

  onProfileChange(profile) {
    console.log('MainMenu', profile);
    this.setState({user: profile});
  }

  render() {
    let profileWidget = "";
    if(this.props.profile) {
      profileWidget = (
        <Link className="main-menu__profile" to="/profile">
          <UserImage user={this.props.profile}/>
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
        <Modal ref="projectListModal">
          <ProjectList onProjectSelected={this.hideProjectList.bind(this)} ref="projectList"/>
        </Modal>
      </nav>
    );
  }
}

const mapStateToProps = (state) => {
  return {
    profile: state.profile.profile
  }
};

export default connect(mapStateToProps)(MainMenu);
