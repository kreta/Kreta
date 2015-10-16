/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import ReactDOM from 'react-dom';
import $ from 'jquery';

export default {
  getInitialState() {
    return {
      selectedItem: 0
    };
  },
  componentDidMount() {
    $(ReactDOM.findDOMNode(this)).on('keyup', $.proxy(this.handleNavigation, this));
  },
  selectNext() {
    if (this.state.selectedItem + 1 < this.refs.navigableList.children.length) {
      this.setState({
        selectedItem: this.state.selectedItem + 1
      });
      this.centerListScroll();
    }
  },
  selectPrev() {
    if (this.state.selectedItem > 0) {
      this.setState({
        selectedItem: this.state.selectedItem - 1
      });
      this.centerListScroll();
    }
  },
  handleNavigation(ev) {
    if (ev.which === 40) { // Down
      this.selectNext(ev);
    } else if (ev.which === 38) { // Up
      this.selectPrev();
    }
  },
  centerListScroll() {
    this.refs.navigableList.scrollTop = this.state.selectedItem * 60 - 60 * 2;
  },
  componentWillUnmount() {
    $(ReactDOM.findDOMNode(this)).off('keyup', this.handleNavigation);
  }
};
