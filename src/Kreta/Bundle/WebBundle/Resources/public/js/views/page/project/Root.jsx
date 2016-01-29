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
import { connect } from 'react-redux';

import CurrentProjectActions from '../../../actions/CurrentProject';

export default class ProjectRoot extends React.Component {
  componentDidMount() {
    this.props.dispatch(CurrentProjectActions.fetchProject(this.props.params.projectId));
  }

  componentDidUpdate(prevProps) {
    const oldId = prevProps.params.projectId,
      newId = this.props.params.projectId;
    if (newId !== oldId) {
      this.props.dispatch(CurrentProjectActions.fetchProject(newId));
    }
  }

  render() {
    return (
      this.props.children
    )
  }
}

const mapStateToProps = (state) => {
  return {}
};

export default connect(mapStateToProps)(ProjectRoot);
