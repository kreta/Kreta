/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/components/_page-header';

import AlloyEditor from 'alloyeditor';
import React from 'react';

class Textarea extends React.Component {
  static propTypes = {
//    configuration: React.PropTypes.string.isRequired,
    content: React.PropTypes.string,
    id: React.PropTypes.string.isRequired
  };

  componentDidMount() {
    this._editor = AlloyEditor.editable(this.props.id, this.props.alloyEditorConfig);
  }

  componentWillUnmount() {
    this._editor.destroy();
  }

  render() {
    const {content, ...props} = this.props;

    return (
      <div {...props}>
        {content}
      </div>
    );
  }
}

export default Textarea;
