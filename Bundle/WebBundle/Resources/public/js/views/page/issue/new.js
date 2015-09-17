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

    this.issuePriorities = new IssuePriorityCollection();
    this.issueTypes = new IssueTypeCollection();

    //Bad practise need to find a better way
    this.model.set('selectableProjects', App.collection.project.models);
    this.onProjectSelected(this.model.get('project'));

    this.listenTo(this.issueTypes, 'reset', this.updateSelectors);
    this.listenTo(this.issuePriorities, 'reset', this.updateSelectors);
  }

  onRender() {
    if (this.selectorsLeft !== 0) {
      this.ui.issueDetails.hide();
    }

    new SelectorView(this.ui.assignee);
    new SelectorView(this.ui.priority);
    new SelectorView(this.ui.type);

    this.$project = new SelectorView(this.ui.project, {
      onSelect: (ev) => {
        if($(ev.currentTarget).val() != "") {
          this.onProjectSelected(App.collection.project.get($(ev.currentTarget).val()));
          this.ui.issueDetails.hide();
        }
      },
      containerCss: 'project-new__project-selector'
    });

  }

  onProjectSelected(project) {
    if(!project) {
      return;
    }

    this.model.set('project', project);

    this.selectorsLeft = 2;

    this.issueTypes.setProject(this.model.get('project').id).fetch({reset: true});
    this.issuePriorities.setProject(this.model.get('project').id).fetch({reset: true});
  }

  updateSelectors() {
    this.model.attributes.project.set('issue_types', this.issueTypes.models);
    this.model.attributes.project.set('issue_priorities', this.issuePriorities.models);
    this.selectorsLeft--;
    this.render()
  }

  save(ev) {
    ev.preventDefault();

    this.ui.actions.hide();

    var project = this.model.get('project').id;

    this.model = FormSerializerService.serialize(
      $('#issue-new'), Issue
    );

    this.model.set('project', project);


    this.model.save(null, {
      success: (model) => {
        App.router.base.navigate('/project/' + project, true);
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
