/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../../scss/views/page/project/_settings';

import React from 'react';
import { connect } from 'react-redux';

import Button from './../../component/Button';
import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import ContentRightLayout from './../../layout/ContentRightLayout';
import ProjectEdit from './Edit';
import SettingsParticipants from './SettingsParticipants';
import UserPreview from './../../component/UserPreview';
import CurrentProjectActions from '../../../actions/CurrentProject';

class Settings extends React.Component {
  componentDidMount() {
    this.props.dispatch(CurrentProjectActions.fetchProject(this.props.params.projectId));
  }

  addParticipant(participant) {
    this.props.dispatch(CurrentProjectActions.addParticipant(participant));
  }

  render() {
    if (!this.props.project) {
      return <div>Loading...</div>;
    }

    const participants = this.props.project.participants.map((participant, index) => {
      return <UserPreview key={index} user={participant.user}/>;
    });

    return (
      <div>
        <ContentMiddleLayout>
          <ProjectEdit project={this.props.project}/>
          <section className="spacer-vertical-1">
            <div className="section-header">
              <h3 className="section-header-title">
                <strong>People</strong> in this project
              </h3>
              <div className="section-header-actions">
                <Button color="green">
                  Add people
                </Button>
              </div>
            </div>
            <div className="project-settings__participants">
              {participants}
            </div>
          </section>
        </ContentMiddleLayout>
        <ContentRightLayout isOpen={true}>
          <SettingsParticipants
            onParticipantAddClicked={this.addParticipant.bind(this)}
            project={this.props.project}
          />
        </ContentRightLayout>
      </div>
    );
  }
}

const mapStateToProps = (state) => {
  return {
    project: state.currentProject.project
  }
};

export default connect(mapStateToProps)(Settings);
