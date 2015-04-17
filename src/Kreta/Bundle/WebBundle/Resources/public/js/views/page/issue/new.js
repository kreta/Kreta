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
import {UserCollection} from '../../../collections/user';
import {ParticipantCollection} from '../../../collections/participant';
import {ProjectCollection} from '../../../collections/project';
import {IssueTypeCollection} from '../../../collections/issue-type';
import {IssuePriorityCollection} from '../../../collections/issue-priority';

export class CreateIssueView extends Backbone.View {
  constructor () {
    this.className = 'kreta-create-issue';
    this.template = _.template($('#kreta-create-issue-template').html());
    this.events = {
      'submit #kreta-create-task': 'save'
    };

    super();

    this.projects = new ProjectCollection();
    this.participants = new ParticipantCollection();
    this.issuePriorities = new IssuePriorityCollection();
    this.issueTypes = new IssueTypeCollection();

    this.listenTo(this.projects, 'add', this.updateProjects);
    this.listenTo(this.projects, 'reset', this.updateProjects);
    this.listenTo(this.participants, 'add', this.updateSelectors);
    this.listenTo(this.participants, 'reset', this.updateSelectors);
    this.listenTo(this.issueTypes, 'add', this.updateSelectors);
    this.listenTo(this.issueTypes, 'reset', this.updateSelectors);
    this.listenTo(this.issuePriorities, 'add', this.updateSelectors);
    this.listenTo(this.issuePriorities, 'reset', this.updateSelectors);

    this.projects.fetch();

    this.render();
  }

  render () {
    this.$el.html(this.template({}));

    this.$assignee = new SelectorView(this.$el.find('.selector-assignee'));
    this.$priorities = new SelectorView(this.$el.find('.selector-priority'));
    this.$dueDate = new SelectorView(this.$el.find('.selector-due-date'));
    this.$type = new SelectorView(this.$el.find('.selector-type'));
    this.$project = new SelectorView(this.$el.find('.selector-project'));

    this.$project.onOptionSelectedCallback = $.proxy(this.onProjectSelected, this);

    return this;
  }

  onProjectSelected (id) {
    this.participants.setProject(id).fetch();
    this.issueTypes.setProject(id).fetch();
    this.issuePriorities.setProject(id).fetch();
  }

  updateProjects () {
    this.$project.setSelectables(this.projects);
  }

  updateSelectors () {
    var users = new UserCollection();
    this.participants.each((participant) => {
       users.push(participant.get('user'));
    });
    this.$assignee.setSelectables(users);
    this.$type.setSelectables(this.issueTypes);
    this.$priorities.setSelectables(this.issuePriorities);
  }

  save (ev) {
    ev.preventDefault();
    var formData = {};
    $.each($('#kreta-create-task').serializeArray(), function (field) {
      formData[this.name] = this.value;
    });

    var issue = new Issue(formData);
    issue.save(null, {success: function(model) {
      App.router.navigate('/issue/' + model.get('id'), true);
    }});
  }
}
