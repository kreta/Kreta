import React from 'react';

export default React.createClass({
  render() {
    return (
      <div id="content">
        {this.props.children}
      </div>
    );
  }
})
