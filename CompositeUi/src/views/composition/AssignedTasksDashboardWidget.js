/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import React from 'react';

import {routes} from './../../Routes';

import CardMinimal from './../component/CardMinimal';
import DashboardWidget from './../component/DashboardWidget';

class AssignedTasksDashboardWidget extends React.Component {
  static propTypes = {
    tasks: React.PropTypes.arrayOf(
      React.PropTypes.object
    ).isRequired,
  };

  renderTasks() {
    const {tasks} = this.props;

    if (tasks.length === 0) {
      return;
    }

    return tasks.map((task, index) => (
      <CardMinimal
        key={index}
        title={`${task.title}`}
        to={routes.task.show(task.project.organization.slug, task.project.slug, task.numeric_id)}
      />
    ));
  }

  render() {
    return (
      <DashboardWidget>
        {this.renderTasks()}
      </DashboardWidget>
    );
  }
}

export default AssignedTasksDashboardWidget;
