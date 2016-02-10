/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import '../../../../../node_modules/quill/dist/quill.snow.css';

import './../../../scss/components/_textarea';

import React from 'react';
import ReactQuill from 'react-quill';
import ReactDOM from 'react-dom';

class Textarea extends React.Component {
  static propTypes = {
    id: React.PropTypes.string.isRequired,
    readOnly: React.PropTypes.bool.isRequired,
    value: React.PropTypes.string
  };

  getValue() {
    return this.refs.editor.getEditor().editor.innerHTML;
  }

  render() {
    const
      { ...props} = this.props,
      formats = [
        {name: 'h1', tag: 'H1', prepare: 'heading', type: 'line'},
//        { name: 'h2', tag: 'H2', prepare: 'heading', type: 'line' },
//        { name: 'h3', tag: 'H3', prepare: 'heading', type: 'line' },
//        { name: 'code', tag: 'code', prepare: 'heading', type: 'line' }
      ];

    let toolbar = [{
      label: 'Main', type: 'group', items: [
        {type: 'bold', label: 'Bold'},
        {type: 'italic', label: 'Italic'},
        {type: 'underline', label: 'Underline'},
        {type: 'link', label: 'Link'},
        {type: 'image', label: 'Image'},
        {type: 'h1', label: 'Header 1', value: 'H1'},
//        {type: 'h2', label: 'Header 2', value: 'H2'},
//        {type: 'h3', label: 'Header 3', value: 'H3'},
//        {type: 'code', label: 'Code', value: 'code'},
        {type: 'strike', label: 'Strike'},
        {
          label: 'Alignment', type: 'align', items: [
          {label: '', value: 'center'},
          {label: '', value: 'left'},
          {label: '', value: 'right'},
          {label: '', value: 'justify'}
        ]
        },
        {type: 'color', label: 'Color', items: ReactQuill.Toolbar.defaultColors},
        {type: 'list', label: 'List'},
        {type: 'bullet', label: 'Bullet'}
      ]
    }];

    if (true === this.props.readOnly) {
      toolbar = false;
    }

    return (
      <ReactQuill
        formats={formats}
        ref="editor"
        theme="snow"
        toolbar={toolbar}
        { ...props}
      />
    );
  }
}

export default Textarea;
