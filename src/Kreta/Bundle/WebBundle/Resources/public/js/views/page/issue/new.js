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
import {Project} from '../../../models/project';
import {ProjectCollection} from '../../../collections/project';
import {IssueTypeCollection} from '../../../collections/issue-type';
import {IssuePriorityCollection} from '../../../collections/issue-priority';

export class IssueNewView extends Backbone.View {
  constructor(options) {
    this.className = 'issue-new';
    this.template = _.template($('#issue-new-template').html());
    this.events = {
      'submit #issue-new': 'save'
    };

    super();

    if (typeof options === 'undefined') {
      this.issue = new Issue();
      this.projects = new ProjectCollection();
      this.listenTo(this.projects, 'reset', this.updateProjects);
      this.projects.fetch({reset: true});
    } else {
      this.issue = options.issue;
      this.issue.on('sync', this.getCurrentProject, this);
      this.issue.fetch();
    }

    this.issuePriorities = new IssuePriorityCollection();
    this.issueTypes = new IssueTypeCollection();

    this.listenTo(this.issueTypes, 'reset', this.updateSelectors);
    this.listenTo(this.issuePriorities, 'reset', this.updateSelectors);
  }

  render() {
    this.$el.html(this.template(this.issue.toJSON()));

    this.$el.find('.issue-new-details').hide();

    this.renderSelectors();

    this.$project.onOptionSelectedCallback = $.proxy(this.onProjectSelected, this);

    return this;
  }

  renderSelectors() {
    this.$assignee = new SelectorView(this.$el.find('.selector-assignee'));
    this.$priorities = new SelectorView(this.$el.find('.selector-priority'));
    /*this.$dueDate = new SelectorView(this.$el.find('.selector-due-date'));*/
    this.$type = new SelectorView(this.$el.find('.selector-type'));
    this.$project = new SelectorView(this.$el.find('.selector-project'));
  }

  updateProjects() {
    this.$project.setSelectables(this.projects.models);
  }

  onProjectSelected(project) {
    this.currentProject = project.id;

    this.selectorsLeft = 2;
    this.$el.find('.issue-new-details').hide();

    var users = [];
    project.get('participants').forEach((participant) => {
      users.push(new User(participant.user));
    });
    this.$assignee.setSelectables(users);

    this.issueTypes.setProject(project.id).fetch({reset: true});
    this.issuePriorities.setProject(project.id).fetch({reset: true});
  }

  getCurrentProject(issue) {
    $.get(issue.get('_links').project.href, (project) => {
      this.render();
      this.onProjectSelected(new Project(project));
    });
  }

  updateSelectors() {
    this.$type.setSelectables(this.issueTypes.models);
    this.$priorities.setSelectables(this.issuePriorities.models);

    this.selectorsLeft--;

    if (this.selectorsLeft == 0) {
      this.$el.find('.issue-new-details').show();
    }
  }

  save(ev) {
    ev.preventDefault();
    var formData = {};
    $.each($('#issue-new').serializeArray(), function (field) {
      formData[this.name] = this.value;
    });

    formData['project'] = this.currentProject;

    if(typeof(this.issue.id) !== 'undefined') {
      formData['id'] = this.issue.id;
    }

    this.issue = new Issue(formData);

    this.issue.save(null, {
      success: (model) => {
        App.router.navigate('/project/' + this.currentProject, true);
        App.router.navigate('/issue/' + model.get('id'), true);
      }
    });
  }
}
