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

import bold from './../../svg/wysiwyg/bold.svg';
import center from './../../svg/wysiwyg/align-center.svg';
import color from './../../svg/wysiwyg/color.svg';
import image from './../../svg/wysiwyg/image.svg';
import italic from './../../svg/wysiwyg/italic.svg';
import justify from './../../svg/wysiwyg/align-justify.svg';
import left from './../../svg/wysiwyg/align-left.svg';
import link from './../../svg/wysiwyg/link.svg';
import monospace from './../../svg/wysiwyg/monospace.svg';
import ordered from './../../svg/wysiwyg/ordered.svg';
import right from './../../svg/wysiwyg/align-right.svg';
import strikethrough from './../../svg/wysiwyg/strikethrough.svg';
import subscript from './../../svg/wysiwyg/subscript.svg';
import superscript from './../../svg/wysiwyg/superscript.svg';
import underline from './../../svg/wysiwyg/underline.svg';
import unordered from './../../svg/wysiwyg/unordered.svg';
import unlink from './../../svg/wysiwyg/unlink.svg';

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
    bold: {icon: bold},
    italic: {icon: italic},
    underline: {icon: underline},
    strikethrough: {icon: strikethrough},
    monospace: {icon: monospace},
    superscript: {icon: superscript},
    subscript: {icon: subscript},
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
    unordered: {icon: unordered, className: 'wysiwyg__toolbar--list-unordered'},
    ordered: {icon: ordered, className: 'wysiwyg__toolbar--list-ordered'}
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
    left: {icon: left},
    center: {icon: center},
    right: {icon: right},
    justify: {icon: justify},
  },
  colorPicker: {icon: color},
  link: {
    inDropdown: false,
    options: [
      'link',
      'unlink'
    ],
    link: {icon: link},
    unlink: {icon: unlink},
  },
  image: {icon: image},
};

class Wysiwyg extends React.Component {
  render() {
    const
      {className, hasPlaceholder} = this.props,
      wrapperClassName = `${className} wysiwyg`;

    let placeholder = '';
    if (hasPlaceholder) {
      placeholder = "Type something...";
    }

    return (
      <Editor
        editorClassName="wysiwyg__editor"
        onBlur={this.blur.bind(this)}
        onFocus={this.focus.bind(this)}
        placeholder={placeholder}
        ref="input"
        spellCheck
        toolbar={toolbar}
        toolbarClassName="wysiwyg__toolbar"
        wrapperClassName={wrapperClassName}
      />
    );
  }

  focus() {
    this.refs.input.editor.focus();
  }

  blur() {
    this.refs.input.editor.blur();
  }
}

export default Wysiwyg;
