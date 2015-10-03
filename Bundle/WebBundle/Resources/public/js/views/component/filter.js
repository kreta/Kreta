/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export default React.createClass({
  render() {
    var filtersEl = this.props.filters.map((filter) => {
      var groupFilters = filter.map((item) => {
        return (
          <a className={`filter-item ${ item.selected ? 'selected' : ''} `}
          data-filter={ item.filter }
          data-value={ item.value }>{item.title}</a>
        );
      });
      return <div className="filter-group">{groupFilters}</div>
    });

    return (
      <div className="filter">
        {filtersEl}
      </div>
    )
  }
})
