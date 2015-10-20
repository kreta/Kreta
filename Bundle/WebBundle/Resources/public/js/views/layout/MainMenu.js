/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import '../../../scss/layout/_main-menu.scss';

import React from 'react';
import {Link} from 'react-router';

import Modal from '../component/Modal.js';
import ProjectList from '../page/project/List.js';

export default React.createClass({
  getInitialState() {
    return {
      user: App.currentUser,
      projectListVisible: false
    };
  },
  showProjectList(ev) {
    this.refs.projectListModal.openModal();
    ev.preventDefault();
  },
  hideProjectList() {
    this.refs.projectListModal.closeModal();
  },
  render() {
    return (
      <nav className="menu">
        <img className="menu-logo" src=""/>
        <div className="menu-user">
          <img className="menu-user-image" src={this.state.user.get('photo').name}/>
          <span className="menu-user-name">@{this.state.user.get('username')}</span>
        </div>
        <div>
          <a className="menu-action">
            <i className="fa fa-sign-out"></i>
            <span className="menu-notification-bubble">4</span>
          </a>
          <a className="menu-action projects"
             onClick={this.showProjectList}>
            <i className="fa fa-sign-out"></i>
          </a>
          <Link to="/profile">
            <i className="fa fa-sign-out"></i>
          </Link>
          <a className="menu-action"
             href="/logout">
            <i className="fa fa-sign-out"></i>
          </a>
        </div>
        <Modal ref="projectListModal">
          <ProjectList onProjectSelected={this.hideProjectList}/>
        </Modal>
      </nav>
    );
  }
});
