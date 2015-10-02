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
import {NotificationService} from '../../../service/notification';
import {FormSerializerService} from '../../../service/form-serializer';

export class IssueNewView extends Backbone.Marionette.ItemView {
  constructor(options = {}) {
    _.defaults(options, {
      className: 'issue-new',
      template: _.template($('#issue-new-template').html()),
      events: {
        'submit @ui.form': 'save'
      }
    });
    super(options);

    // Bad practise need to find a better way, templateHelpers???
    this.model.set('selectableProjects', App.collection.project.models);
    this.onProjectSelected(this.model.get('project'));

    this.listenTo(this.model.get('project'), 'change', this.updateSelectors);
  }

  ui() {
    return {
      form: '#issue-new',
      project: 'select[name="project"]',
      title: 'input[name="title"]',
      assignee: 'select[name="assignee"]',
      priority: 'select[name="priority"]',
      type: 'select[name="type"]',
      issueDetails: '.issue-new-details',
      actions: '.issue-new-actions'
    };
  }

  onRender() {
    if (this.selectorsLeft !== 0) {
      this.ui.issueDetails.hide();
    }

    new SelectorView(this.ui.assignee);
    new SelectorView(this.ui.priority);
    new SelectorView(this.ui.type);
    new SelectorView(this.ui.project, {
      onSelect: (ev) => {
        if ($(ev.currentTarget).val() !== '') {
          this.onProjectSelected(
            App.collection.project.get($(ev.currentTarget).val())
          );
          this.ui.issueDetails.hide();
        }
      }
    });

    this.ui.title.focus();
  }

  onProjectSelected(project) {
    if (!project) {
      return;
    }

    this.model.set('project', project);

    this.selectorsLeft = 2;

    this.model.get('project').get('issue_types');
    this.model.get('project').get('issue_priorities');
  }

  updateSelectors() {
    this.selectorsLeft--;
    this.render();
  }

  save() {
    this.ui.actions.hide();

    var project = this.model.get('project');

    this.model = FormSerializerService.serialize(
      this.ui.form, Issue
    );

    this.model.save(null, {
      success: (model) => {
        App.router.base.navigate(`/project/${project.id}`, true);
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
        this.model.set('project', project);
      }
    });

    return false;
  }
}
