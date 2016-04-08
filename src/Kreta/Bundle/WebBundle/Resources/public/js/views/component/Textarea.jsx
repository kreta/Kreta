/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../../../node_modules/quill/dist/quill.snow.css';

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

  constructor(props) {
    super(props);
    this.state = {
      value: this.props.value
    };

    this.formats = [
      'bold',
      'italic',
      'strike',
      'underline',
      'size',
      'color',
      'link',
      'bullet',
      'list',
      'align',
      { name: 'code', tag: 'code', prepare: 'heading', type: 'line' }
    ];

    this.toolbar = [
      {
        label: 'Formats', type: 'group', items: [
        {
          label: 'Size', type: 'size', items: [
            {label: 'small', value: '10px'},
            {label: 'normal', value: '13px', selected: true},
            {label: 'title', value: '18px'}
          ]
        }, {
          label: 'Alignment', type: 'align', items: [
            {label: '', value: 'left', selected: true},
            {label: '', value: 'center'},
            {label: '', value: 'right'},
            {label: '', value: 'justify'}
          ]
        }, {
          type: 'separator'
        }]
      }, {
        label: 'Text', type: 'group', items: [
          {type: 'bold', label: 'Bold'},
          {type: 'italic', label: 'Italic'},
          {type: 'strike', label: 'Strike'},
          {type: 'underline', label: 'Underline'},
          {type: 'separator'},
          {type: 'link', label: 'Link'},
          {type: 'bullet', label: 'Bullet'},
          {type: 'list', label: 'List'},
          {type: 'code', label: 'Code', value: 'code'},
          {type: 'color', label: 'Color', items: ReactQuill.Toolbar.defaultColors}
        ]
      }
    ];

    if (true === this.props.readOnly) {
      this.toolbar = false;
    }
  }

  componentWillReceiveProps(nextProps) {
    this.setState({
      value: nextProps.value
    });
  }

  onChange(value) {
    this.setState({
      value: value
    });
  }

  render() {
    return (
      <div>
        <input name="description" type="hidden" value={this.state.value}/>
        <ReactQuill
          formats={this.formats}
          onChange={this.onChange.bind(this)}
          ref="editor"
          theme="snow"
          toolbar={this.toolbar}
          value={this.state.value}
        />
      </div>
    );
  }
}

export default Textarea;
