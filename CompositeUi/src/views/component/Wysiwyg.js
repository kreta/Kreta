/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_wysiwyg.scss';

import React from 'react';
import {Editor} from 'react-draft-wysiwyg';

const toolbar = {
  options: [
    'inline',
    'blockType',
    'list',
    'textAlign',
    'colorPicker',
    'link',
    'image',
  ],
  inline: {
    inDropdown: false,
    options: [
      'bold',
      'italic',
      'underline',
      'strikethrough',
      'monospace',
      'superscript',
      'subscript'
    ],
  },
  blockType: {
    inDropdown: false,
    options: [
      'H1',
      'H2',
      'H3',
      'H4',
      'Blockquote'
    ],
  },
  list: {
    inDropdown: false,
    className: undefined,
    options: [
      'unordered',
      'ordered'
    ],
    unordered: {className: 'wysiwyg__toolbar--list-unordered'},
    ordered: {className: 'wysiwyg__toolbar--list-ordered'}
  },
  textAlign: {
    inDropdown: false,
    className: undefined,
    options: [
      'left',
      'center',
      'right',
      'justify'
    ],
  },
  link: {
    inDropdown: false,
    options: [
      'link',
      'unlink'
    ],
  },
};

class Wysiwyg extends React.Component {
  static propTypes = {
    editorOnBlur: React.PropTypes.func,
    editorOnChange: React.PropTypes.func,
    editorOnFocus: React.PropTypes.func,
    hasPlaceholder: React.PropTypes.bool,
    tabIndex: React.PropTypes.number
  };

  static defaultProps = {
    editorOnBlur: () => {},
    editorOnChange: () => {},
    editorOnFocus: () => {},
  };

  constructor(props) {
    super(props);

    this.handleBlur = this.handleBlur.bind(this);
    this.handleChange = this.handleChange.bind(this);
    this.handleFocus = this.handleFocus.bind(this);
  }

  handleBlur() {
    return this.props.editorOnBlur();
  }

  handleChange(content) {
    if (typeof content.blocks === 'undefined') {
      return;
    }
    let value = 0;
    content.blocks.forEach((block) => {
      value += +block.text.length;
    });

    return this.props.editorOnChange(value);
  }

  handleFocus() {
    return this.props.editorOnFocus();
  }

  render() {
    const
      {hasPlaceholder, tabIndex} = this.props;

    let placeholder = '';
    if (hasPlaceholder) {
      placeholder = 'Type something...';
    }

    return (
      <Editor
        editorClassName="wysiwyg__editor"
        onBlur={this.handleBlur}
        onContentStateChange={this.handleChange}
        onFocus={this.handleFocus}
        placeholder={placeholder}
        spellCheck
        tabIndex={tabIndex}
        toolbar={toolbar}
        toolbarClassName="wysiwyg__toolbar"
        wrapperClassName="wysiwyg"
      />
    );
  }
}

export default Wysiwyg;
