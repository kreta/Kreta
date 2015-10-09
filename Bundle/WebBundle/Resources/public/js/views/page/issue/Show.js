/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import './../../../../scss/views/page/issue/_show.scss';

import React from 'react';

export default React.createClass({
  propTypes: {
    issue: React.PropTypes.object
  },
  render() {
    const issue = this.props.issue.toJSON();
      /*transitions = this.props.issue.get('transitions').map((transition) => {
        return (
          <button className="button green full-issue-transition" data-transition={transition.id}>
            {transition.name}
          </button>
        );
      });*/
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
            <small>Priority</small> {issue.priority.name}
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
/*export class IssueShowView extends Backbone.Marionette.ItemView {
 constructor(options = {}) {
 _.defaults(options, {
 className: 'full-issue-aside spacer-2',
 template: '#issue-show-template',
 events: {
 'click .full-issue-tab': 'tabClicked',
 'click .full-issue-transition': 'doTransition'
 }
 });
 super(options);

 this.model.on('change', this.render, this);
 App.vent.trigger('issue:highlight', this.model.id);
 }

 ui() {
 return {
 'tabContent': '.full-issue-tab-content',
 'transitions': '.full-issue-transitions'
 };
 }

 serializeData() {
 var data = this.model.toJSON();

 data.transitions = this.model.getAllowedTransitions();
 data.canEdit = this.model.canEdit(App.currentUser);

 return data;
 }

 tabClicked(ev) {
 var pos = $(ev.currentTarget).index();

 this.ui.tabContent.removeClass('visible');
 $(this.ui.tabContent.get(pos)).addClass('visible');

 return false;
 }

 doTransition(ev) {
 this.ui.transitions.hide();
 this.model.doTransition($($(ev)[0].currentTarget).attr('data-transition'), {
 success: (data) => {
 this.model.set(data);
 App.vent.trigger('issue:updated', data);
 }
 });

 return false;
 }
 }*/
