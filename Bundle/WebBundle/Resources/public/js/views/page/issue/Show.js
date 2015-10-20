/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../../scss/views/page/issue/_show.scss';

import React from 'react';

export default React.createClass({
  propTypes: {
    issue: React.PropTypes.object
  },
  render() {
    const issue = this.props.issue.toJSON();

    return (
      <div className="full-issue">
        <h2 className="full-issue-title">{issue.title}</h2>
        <section className="full-issue-transitions">

        </section>
        <section className="full-issue-dashboard">
          <p className="full-issue-dashboard-item">
            <img className="user-image" src={issue.assignee.photo.name}/>
            <small>Assigned to</small>
            <strong>{issue.assignee.first_name} {issue.assignee.last_name}</strong>
          </p>
          <p className="full-issue-dashboard-item half">
            <i className="fa fa-exclamation"></i>
            <small>Priority</small>
            {issue.priority.name}
          </p>
          <p className="full-issue-dashboard-item half">
            <i className="fa fa-coffee"></i>{issue.type.name}
          </p>
        </section>
        <p className="full-issue-description">{issue.description}</p>
      </div>
    );
  }
});
