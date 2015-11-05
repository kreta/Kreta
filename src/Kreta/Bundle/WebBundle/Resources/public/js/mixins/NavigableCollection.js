/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import $ from 'jquery';
import ReactDOM from 'react-dom';

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
