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

import Button from './../../component/Button';
import ContentMiddleLayout from './../../layout/ContentMiddleLayout';
import ContentRightLayout from './../../layout/ContentRightLayout';
import ProjectEdit from './Edit';
import SettingsParticipants from './SettingsParticipants';
import UserPreview from './../../component/UserPreview';

class Settings extends React.Component {
  state = {
    project: null,
    userSelectorVisible: false
  };

  componentDidMount() {
    const project = App.collection.project.get(this.props.params.projectId);
    project.on('change', (p) => {
      this.setState({project: p});
    });
    this.setState({project});
  }

  showNotParticipantingList() {
    this.setState({userSelectorVisible: true});
  }

  updateParticipants() {
    this.state.project.fetch();
  }

  render() {
    if (!this.state.project) {
      return <div>Loading...</div>;
    }

    const participants = this.state.project.get('participants').map((participant, index) => {
      return <UserPreview key={index} user={participant.user}/>;
    });

    return (
      <div>
        <ContentMiddleLayout>
          <ProjectEdit project={this.state.project}/>
          <section className="spacer-vertical-1">
            <div className="section-header">
              <h3 className="section-header-title">
                <strong>People</strong> in this project
              </h3>
              <div className="section-header-actions">
                <Button color="green"
                  onClick={this.showNotParticipantingList.bind(this)}>
                  Add people
                </Button>
              </div>
            </div>
            <div className="project-settings__participants">
              {participants}
            </div>
          </section>
        </ContentMiddleLayout>
        <ContentRightLayout open={this.state.userSelectorVisible}>
          <SettingsParticipants
            onParticipantAdded={this.updateParticipants.bind(this)}
            project={this.state.project}
          />
        </ContentRightLayout>
      </div>
    );
  }
}

export default Settings;
