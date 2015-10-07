/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import React from 'react';

export default React.createClass({
  componentWillMount() {
    /* this.listenTo(App.vent, 'issue:highlight', (issueId) => {
     this.highlightIssue(issueId);
     });

     this.listenTo(App.vent, 'issue:updated', (issue) => {
     if (this.model.id === issue.id) {
     this.model.set(issue);
     this.render();
     }
     }); */
  },
  showFullIssue() {
    if (this.props.onIssueSelected) {
      this.props.onIssueSelected();
    }
  },
  hightlightIssue(issueId) {
    this.setState({highlighted: issueId === this.props.issue.id});
  },
  render() {
    return (
      <div className="list-issue">
        <div className="list-issue-details">
          <a className="list-issue-title">
            {this.props.issue.get('title')}
          </a>
        </div>
        <div className="list-issue-icons">
          <span className="list-issue-icon"
                data-tooltip-text={ this.props.issue.get('status').name }>
            <i className="fa fa-check" style={{color: this.props.issue.get('status').color }}></i>
          </span>
          <span
            data-tooltip-text={`
              ${this.props.issue.get('assignee').first_name}
              ${this.props.issue.get('assignee').last_name}`}>
            <img className="user-image" src={this.props.issue.get('assignee').photo.name }/>
          </span>
        </div>
      </div>
    );
  }
})
