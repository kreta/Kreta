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
import {NotificationService} from '../../../service/notification';
import {FormSerializerService} from '../../../service/form-serializer';

export class IssueNewView extends Backbone.Marionette.ItemView {
  constructor(options) {
    this.className = 'issue-new';
    this.template = _.template($('#issue-new-template').html());
    this.events = {
      'submit #issue-new': 'save'
    };

    this.ui = {
      project: 'select[name="project"]',
      assignee: 'select[name="assignee"]',
      priority: 'select[name="priority"]',
      type: 'select[name="type"]',
      issueDetails: '.issue-new-details'
    };

    super(options);

    if (this.model.isNew()) {
      this.projects = App.collection.project;
      this.listenTo(App.collection.project, 'reset', this.updateProjects);
    } else {
      this.model.on('sync', this.getCurrentProject, this);
      this.getCurrentProject(this.model);
    }

    this.issuePriorities = new IssuePriorityCollection();
    this.issueTypes = new IssueTypeCollection();

    this.listenTo(this.issueTypes, 'reset', this.updateSelectors);
    this.listenTo(this.issuePriorities, 'reset', this.updateSelectors);
  }

  onRender() {
    this.ui.issueDetails.hide();

    this.renderSelectors();
    this.updateProjects();

    this.$project.onOptionSelected($.proxy(this.onProjectSelected, this));
    this.$project.select2("open");

    return this;
  }

  renderSelectors() {
    this.$assignee = new SelectorView(this.ui.assignee);
    this.$priority = new SelectorView(this.ui.priority);
    this.$type = new SelectorView(this.ui.type);
    this.$project = new SelectorView(this.ui.project);
  }

  updateProjects() {
    this.projects = App.collection.project;
    this.$project.setSelectables(this.projects.models);
  }

  onProjectSelected(ev) {
    this.currentProject = this.projects.get($(ev.currentTarget).val());

    this.selectorsLeft = 2;
    this.$el.find('.issue-new-details').hide();

    var users = [];
    this.currentProject.get('participants').forEach((participant) => {
      users.push(new User(participant.user));
    });
    this.$assignee.setSelectables(users);

    this.issueTypes.setProject(this.currentProject.id).fetch({reset: true});
    this.issuePriorities.setProject(this.currentProject.id).fetch({reset: true});
  }

  getCurrentProject(issue) {
    if(typeof issue.get('_links') !== 'undefined') {
      $.get(issue.get('_links').project.href, (project) => {
        this.render();
        this.onProjectSelected(new Project(project));
      });
    }
  }

  updateSelectors() {
    this.$type.setSelectables(this.issueTypes.models);
    this.$priority.setSelectables(this.issuePriorities.models);

    this.selectorsLeft--;

    if (this.selectorsLeft === 0) {
      this.$el.find('.issue-new-details').show();
    }
  }

  save(ev) {
    ev.preventDefault();

    var $actions = $('.issue-new-actions');
    $actions.hide();

    this.model = FormSerializerService.serialize(
      $('#issue-new'), Issue
    );

    this.model.set('project', this.currentProject);


    this.model.save(null, {
      success: (model) => {
        App.router.base.navigate('/project/' + this.currentProject, true);
        App.controller.issue.showAction(model);
        NotificationService.showNotification({
          type: 'success',
          message: 'Issue created successfully'
        });
      }, error: function() {
        NotificationService.showNotification({
          type: 'error',
          message: 'Error while saving this issue'
        });
        $actions.show();
      }
    });
  }
}
