/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

/**
 * This behavior allows to make any CompositeView navigable using keyboard
 * and mouse.
 * The following options need to be added in order to make it work:
 *     - originalCollection: The collection that will be used to show filtered
 *                          results. It must implement filter(name) method.
 *     - childViewEl: Selector that points to the childView elements. It's
 *                    required to trigger the "mouse enter" event.
 *     - childHighlightClass: The class that will be added to the childView
 *                            to style the highlight status
 */
export default {
  getInialState() {
    return {
      selectedItem: 0
    }
  },
 componentDidMount() {

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
