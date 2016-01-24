/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../../../node_modules/froala-editor/js/froala_editor.min';

import './../../../../../node_modules/froala-editor/js/plugins/align.min';
import './../../../../../node_modules/froala-editor/js/plugins/image.min';
import './../../../../../node_modules/froala-editor/js/plugins/link.min';
import './../../../../../node_modules/froala-editor/js/plugins/lists.min';
import './../../../../../node_modules/froala-editor/js/plugins/paragraph_format.min';

import './../../../scss/components/_froala';

import $ from 'jquery';
import React from 'react';

class Textarea extends React.Component {
  static propTypes = {
    content: React.PropTypes.string,
    id: React.PropTypes.string.isRequired
  };

  componentDidMount() {
    $.FroalaEditor.DefineIcon('imageInfo', {NAME: 'info'});
    $.FroalaEditor.RegisterCommand('imageInfo', {
      title: 'Info',
      focus: false,
      undo: false,
      refreshAfterCallback: false,
      callback: function () {
        var $img = this.image.get();
        alert($img.attr('src'));
      }
    });

    const toolbarButtons = [
      'bold',
      'italic',
      'underline',
      'insertLink',
      'insertImage',
      'paragraphFormat',
      'strikeThrough',
      'align',
      'formatOL',
      'formatUL',
      'insertHR'
    ];

    $(`#${this.props.id}`).froalaEditor({
      enter: $.FroalaEditor.ENTER_BR,
      heightMax: 300,
      imageEditButtons: [
        'imageDisplay',
        'imageAlign',
        'imageInfo',
        'removeImage'
      ],
      placeholderText: 'Description',
      tabSpaces: 4,
      toolbarButtons: toolbarButtons,
      toolbarButtonsMD: toolbarButtons,
      toolbarButtonsSM: toolbarButtons,
      toolbarButtonsXS: toolbarButtons,
      toolbarSticky: false
    });
  }

  componentWillUnmount() {
    $(`#${this.props.id}`).froalaEditor('destroy');
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
