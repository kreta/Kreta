/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {SelectorView} from '../../component/selector';
import {Issue} from '../../../models/issue';
import {User} from '../../../models/user';
import {ParticipantCollection} from '../../../collections/participant';
import {ProjectCollection} from '../../../collections/project';
import {IssueTypeCollection} from '../../../collections/issue-type';
import {IssuePriorityCollection} from '../../../collections/issue-priority';

export class IssueNewView extends Backbone.View {
  constructor (options) {
    this.className = 'issue-new';
    this.template = _.template($('#issue-new-template').html());
    this.events = {
      'submit #issue-new': 'save'
    };

    super();

    this.issue = typeof options !== 'undefined' ? options.issue : new Issue();

    if(this.issue.isNew) {
      this.projects = new ProjectCollection();
      this.listenTo(this.projects, 'add', this.updateProjects);
      this.listenTo(this.projects, 'reset', this.updateProjects);

      this.projects.fetch();
    }

    this.participants = new ParticipantCollection();
    this.issuePriorities = new IssuePriorityCollection();
    this.issueTypes = new IssueTypeCollection();

    this.listenTo(this.participants, 'add', this.updateSelectors);
    this.listenTo(this.participants, 'reset', this.updateSelectors);
    this.listenTo(this.issueTypes, 'add', this.updateSelectors);
    this.listenTo(this.issueTypes, 'reset', this.updateSelectors);
    this.listenTo(this.issuePriorities, 'add', this.updateSelectors);
    this.listenTo(this.issuePriorities, 'reset', this.updateSelectors);


    this.render();
  }

  render () {
    this.$el.html(this.template({}));

    this.$el.find('.issue-new-details').hide();

    this.$assignee = new SelectorView(this.$el.find('.selector-assignee'));
    this.$priorities = new SelectorView(this.$el.find('.selector-priority'));
    /*this.$dueDate = new SelectorView(this.$el.find('.selector-due-date'));*/
    this.$type = new SelectorView(this.$el.find('.selector-type'));
    this.$project = new SelectorView(this.$el.find('.selector-project'));

    this.$project.onOptionSelectedCallback = $.proxy(this.onProjectSelected, this);

    return this;
  }

  onProjectSelected (project) {
    this.selectorsLeft = 2;
    this.$el.find('.issue-new-details').hide();

    var users = [];
    project.get('participants').forEach((participant) => {
      users.push(new User(participant.user));
    });
    this.$assignee.setSelectables(users);

    this.issueTypes.setProject(project.id).fetch();
    this.issuePriorities.setProject(project.id).fetch();
  }

  updateProjects () {
    this.$project.setSelectables(this.projects.models);
  }

  updateSelectors () {
    this.$type.setSelectables(this.issueTypes.models);
    this.$priorities.setSelectables(this.issuePriorities.models);

    this.selectorsLeft--;

    if(this.selectorsLeft == 0) {
      this.$el.find('.issue-new-details').show();
    }
  }

  save (ev) {
    ev.preventDefault();
    var formData = {};
    $.each($('#issue-new').serializeArray(), function (field) {
      formData[this.name] = this.value;
    });

    var projectId = formData.project;

    this.issue.set(formData);

    this.issue.save(null, {success: function(model) {
      App.router.navigate('/project/' + projectId, true);
      App.router.navigate('/issue/' + model.get('id'), true);
    }});
  }
}
