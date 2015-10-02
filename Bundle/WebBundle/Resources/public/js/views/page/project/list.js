/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {ProjectPreview} from '../../component/projectPreview';
import {ProjectCollection} from '../../../collections/project';

export default React.createClass({
  getInitialState() {
    return {
      projects: App.collection.project,
      selectedItem: 0
    }
  },
  onKeyUp(ev) {
    if (ev.which === 40) { // Down
      if (this.state.selectedItem + 1 < this.ref.projectList.children().length) {
        this.state.selectedItem++;
        this.focusSelectedItem();
        this.centerListScroll();

        return false;
      }

    } else if (ev.which === 38) { // Up
      if (this.state.selectedItem > 0) {
        this.state.selectedItem--;
        this.focusSelectedItem();
        this.centerListScroll();

        return false;
      }
    } else {
      // Delegate keyUp event handling to selected view if selected
      if (this.view.children.length > 0 && !this.view.children.findByIndex(this.state.selectedItem).onKeyUp(ev)) {
        return false;
      }

      this.view.collection.reset(
        this.options.originalCollection.filter(this.ref.filter.val())
      );
      this.state.selectedItem = 0;
      this.focusSelectedItem();
    }
  },
  onMouseEnter(ev) {
    this.state.selectedItem = $(ev.currentTarget).index();
    this.focusSelectedItem();
  },
  centerListScroll() {
    this.ref.projectList.scrollTop(this.state.selectedItem * 60 - 60 * 2);
  },
  render() {
    var projectItems = this.state.projects.map((project, index) => {
      return <ProjectPreview project={project} onMouseEnter={this.onMouseEnter} key={index}/>
    });
    return (
      <div>
        <div className="simple-header">
          <div className="simple-header-filters">
            <span className="simple-header-filter">Sort by <strong>priority</strong></span>
          </div>
          <div className="simple-header-actions">
            <a href="/project/new" className="button green small">New</a>
          </div>
        </div>
        <input className="project-list__filter" type="text" ref="filter"
               onKeyUp={this.onKeyUp}/>
        <ul className="project-preview__list" ref="projectList">
          { projectItems }
        </ul>
      </div>
    );
  }
});
