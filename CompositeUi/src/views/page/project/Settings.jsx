/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/views/page/project/_settings';

import React from 'react';
import {connect} from 'react-redux';

import Button from './../../component/Button';
import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import ContentRightLayout from './../../layout/ContentRightLayout';
import ProjectEdit from './../../form/ProjectEdit';
import Section from './../../component/Section';
import Thumbnail from './../../component/Thumbnail';
import SettingsParticipants from './SettingsParticipants';
import UserPreview from './../../component/UserPreview';
import LoadingSpinner from '../../component/LoadingSpinner.jsx';
import CurrentProjectActions from '../../../actions/CurrentProject';
import PageHeader from '../../component/PageHeader';

@connect(state => ({project: state.currentProject.project}))
export default class extends React.Component {
  state = {
    addParticipantsVisible: false
  };

  addParticipant(participant) {
    this.props.dispatch(CurrentProjectActions.addParticipant(participant));
  }

  showAddParticipants() {
    this.setState({addParticipantsVisible: true});
  }

  updateProject(project) {
    this.props.dispatch(CurrentProjectActions.updateProject(project));
  }

  render() {
    if (!this.props.project) {
      return <LoadingSpinner/>;
    }

    const participants = this.props.project.participants.map(
      (participant, index) => <UserPreview key={index} user={participant.user}/>
    );

    return (
      <div>
        <ContentMiddleLayout>
          <PageHeader thumbnail={<Thumbnail image={this.props.project.image.name} text={this.props.project.name}/>}
                      title={this.props.project.name}/>
          <Section>
            <ProjectEdit onSubmit={this.updateProject.bind(this)}/>
          </Section>
          <Section
            title={<span><strong>People</strong> in this project</span>}
            actions={
              <Button color="green" onClick={this.showAddParticipants.bind(this)}>
                Add people
              </Button>
            }
          >
            <div className="project-settings__participants">
              {participants}
            </div>
          </Section>

        </ContentMiddleLayout>
        <ContentRightLayout isOpen={this.state.addParticipantsVisible}>
          <SettingsParticipants
            onParticipantAddClicked={this.addParticipant.bind(this)}
            project={this.props.project}
          />
        </ContentRightLayout>
      </div>
    );
  }
}
