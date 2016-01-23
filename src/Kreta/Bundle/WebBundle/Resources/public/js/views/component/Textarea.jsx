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
    content: React.PropTypes.string,
    id: React.PropTypes.string.isRequired
  };

  componentDidMount() {
    this._editor = AlloyEditor.editable(this.props.id, {
      toolbars: {
        add: {
          buttons: ['image', 'hline', 'table'],
          tabIndex: 2
        },
        styles: {
          selections: [{
            name: 'link',
            buttons: ['linkEdit'],
            test: AlloyEditor.SelectionTest.link
          }, {
            name: 'image',
            buttons: ['imageLeft', 'imageRight'],
            test: AlloyEditor.SelectionTest.image
          }, {
            name: 'text',
            buttons: ['styles', 'bold', 'italic', 'underline', 'link'],
            test: AlloyEditor.SelectionTest.text
          }, {
            name: 'table',
            buttons: ['tableRow', 'tableColumn', 'tableCell', 'tableRemove'],
            getArrowBoxClasses: AlloyEditor.SelectionGetArrowBoxClasses.table,
            setPosition: AlloyEditor.SelectionSetPosition.table,
            test: AlloyEditor.SelectionTest.table
          }],
          tabIndex: 1
        }
      }
    });
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
