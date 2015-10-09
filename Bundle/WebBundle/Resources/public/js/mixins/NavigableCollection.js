/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export default {
  getInitialState() {
    return {
      selectedItem: 0
    }
  },
  componentDidMount() {
    $(document.body).on('keyup', this.handleNavigation)
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
    console.log('NavigableCollection disabled');
    return false;
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
    $(document.body).off('keyup', this.handleNavigation)
  }
}

/*
 constructor(options, view) {
 _.defaults(options, {
 events: {
 'keyup': 'onKeyUp',
 'mouseenter @ui.childViewEl': 'onMouseEnter'
 }
 });
 super(options, view);

 this.selectedItem = 0;
 }

 ui() {
 return {
 filter: 'input',
 childView: this.view.childViewContainer,
 childViewEl: this.options.childViewEl
 };
 }

 onRender() {
 setTimeout(() => {
 this.focusSelectedItem();
 this.ui.filter.focus();
 }, 100);
 }

 onKeyUp(ev) {
 if (ev.which === 40) { // Down
 if (this.selectedItem + 1 < this.ui.childView.children().length) {
 this.selectedItem++;
 this.focusSelectedItem();
 this.centerListScroll();

 return false;
 }

 } else if (ev.which === 38) { // Up
 if (this.selectedItem > 0) {
 this.selectedItem--;
 this.focusSelectedItem();
 this.centerListScroll();

 return false;
 }
 } else {
 // Delegate keyUp event handling to selected view if selected
 if (this.view.children.length > 0 && !this.view.children.findByIndex(this.selectedItem).onKeyUp(ev)) {
 return false;
 }

 this.view.collection.reset(
 this.options.originalCollection.filter(this.ui.filter.val())
 );
 this.selectedItem = 0;
 this.focusSelectedItem();
 }
 }

 onMouseEnter(ev) {
 this.selectedItem = $(ev.currentTarget).index();
 this.focusSelectedItem();
 }

 focusSelectedItem() {
 this.ui.childView.children().removeClass(this.options.childHighlightClass);
 this.ui.childView.children().eq(this.selectedItem)
 .addClass(this.options.childHighlightClass);
 }

 centerListScroll() {
 this.ui.childView.scrollTop(this.selectedItem * 60 - 60 * 2);
 }
 */
