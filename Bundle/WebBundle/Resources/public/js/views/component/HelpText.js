import React from 'react';

export default React.createClass({
  propTypes: {
    text: React.PropTypes.string.isRequired
  },
  render() {
    return (
        <p className="help-text">
          {this.props.text}
        </p>
    );
  }
})
