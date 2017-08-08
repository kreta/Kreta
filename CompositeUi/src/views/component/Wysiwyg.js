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

import {
  convertToRaw,
  ContentState,
  EditorState,
  convertFromHTML,
} from 'draft-js';
import draftToHtml from 'draftjs-to-html';
import React from 'react';
import {Editor} from 'react-draft-wysiwyg';

const toolbar = {
  options: ['inline', 'blockType', 'list', 'link'],
  inline: {
    inDropdown: false,
    options: ['bold', 'italic', 'underline', 'strikethrough', 'monospace'],
  },
  blockType: {
    inDropdown: false,
    options: ['H1', 'H2', 'H3'],
  },
  list: {
    inDropdown: false,
    className: undefined,
    options: ['unordered', 'ordered'],
    unordered: {className: 'wysiwyg__toolbar--list-unordered'},
    ordered: {className: 'wysiwyg__toolbar--list-ordered'},
  },
  link: {
    inDropdown: false,
    options: ['link', 'unlink'],
  },
  image: {
    className: undefined,
    popupClassName: undefined,
    urlEnabled: false,
    uploadEnabled: true,
    alignmentEnabled: false,
    uploadCallback: () => {
      console.log('test');
    },
  },
};

class Wysiwyg extends React.Component {
  static propTypes = {
    defaultValue: React.PropTypes.string,
    editorOnBlur: React.PropTypes.func.isRequired,
    editorOnChange: React.PropTypes.func.isRequired,
    editorOnFocus: React.PropTypes.func.isRequired,
    hasPlaceholder: React.PropTypes.bool,
    tabIndex: React.PropTypes.number,
  };

  constructor(props) {
    super(props);

    this.handleBlur = this.handleBlur.bind(this);
    this.handleChange = this.handleChange.bind(this);
    this.handleFocus = this.handleFocus.bind(this);
    this.handleTab = this.handleTab.bind(this);
  }

  defaultEditorState() {
    const {defaultValue} = this.props;

    if (null === defaultValue) {
      return null;
    }

    const blocksFromHTML = convertFromHTML(defaultValue),
      state = ContentState.createFromBlockArray(
        blocksFromHTML.contentBlocks,
        blocksFromHTML.entityMap,
      );

    return EditorState.createWithContent(state);
  }

  handleBlur() {
    return this.props.editorOnBlur();
  }

  handleChange(editorState) {
    const content = editorState.getCurrentContent(),
      htmlContent = draftToHtml(convertToRaw(content)),
      isEditorEmpty = content.hasText();

    return this.props.editorOnChange(htmlContent, isEditorEmpty);
  }

  handleFocus() {
    return this.props.editorOnFocus();
  }

  handleTab() {
    // Disables the default behaviour of editor
    // that is to change depth of block.
    return true;
  }

  render() {
    const {hasPlaceholder, tabIndex} = this.props;

    let placeholder = '';
    if (hasPlaceholder) {
      placeholder = 'Type something...';
    }

    return (
      <Editor
        defaultEditorState={this.defaultEditorState()}
        editorClassName="wysiwyg__editor"
        onBlur={this.handleBlur}
        onEditorStateChange={this.handleChange}
        onFocus={this.handleFocus}
        onTab={this.handleTab}
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
