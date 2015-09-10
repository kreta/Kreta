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
      issueDetails: '.issue-new-details',
      actions: '.issue-new-actions'
    };

    super(options);

    this.projects = App.collection.project;
    if (!this.model.isNew()) {
      this.getCurrentProject(this.model);
    }

    this.issuePriorities = new IssuePriorityCollection();
    this.issueTypes = new IssueTypeCollection();

    this.listenTo(this.issueTypes, 'reset', this.updateSelectors);
    this.listenTo(this.issuePriorities, 'reset', this.updateSelectors);
  }

  onRender() {
    this.ui.issueDetails.hide();

    this.$assignee = new SelectorView(this.ui.assignee);
    this.$priority = new SelectorView(this.ui.priority);
    this.$type = new SelectorView(this.ui.type);

    if (this.model.isNew()) {
      this.$project = new SelectorView(this.ui.project, {
        onSelect: (ev) => {
          this.onProjectSelected(this.projects.get($(ev.currentTarget).val()));
        },
        containerCss: 'project-new__project-selector'
      });
      this.$project.setSelectables(this.projects.models);

      setTimeout(() => {
        this.$project.select2("open");
      }, 1000);
    }

    return this;
  }

  onProjectSelected(project) {
    this.currentProject = project;

    this.ui.issueDetails.hide();

    if(!this.currentProject) {
      return;
    }

    this.selectorsLeft = 2;

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

    this.ui.assignee.val(this.model.get('assignee').id).trigger('change');
    this.ui.type.val(this.model.get('type').id).trigger('change');
    this.ui.priority.val(this.model.get('priority').id).trigger('change');

    this.selectorsLeft--;

    if (this.selectorsLeft === 0) {
      this.ui.issueDetails.show();
    }
  }

  save(ev) {
    ev.preventDefault();

    this.ui.actions.hide();

    this.model = FormSerializerService.serialize(
      $('#issue-new'), Issue
    );

    this.model.set('project', this.currentProject.id);


    this.model.save(null, {
      success: (model) => {
        App.router.base.navigate('/project/' + this.currentProject.id, true);
        App.controller.issue.showAction(model);
        NotificationService.showNotification({
          type: 'success',
          message: 'Issue created successfully'
        });
      }, error: () => {
        NotificationService.showNotification({
          type: 'error',
          message: 'Error while saving this issue'
        });
        this.ui.actions.show();
      }
    });
  }
}
