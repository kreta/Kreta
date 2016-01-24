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
    editable: React.PropTypes.oneOf(['on', 'off']),
    id: React.PropTypes.string.isRequired,
    value: React.PropTypes.string
  };

  componentDidUpdate() {
    $.FroalaEditor.DefineIcon('imageInfo', {NAME: 'info'});
    $.FroalaEditor.RegisterCommand('imageInfo', {
      title: 'Info',
      focus: false,
      undo: false,
      refreshAfterCallback: false,
      callback: () => {
        const $img = this.image.get();
        alert($img.attr('src'));
      }
    });

    const
      $editor = $(`textarea#${this.props.id}`),
      toolbarProps = [
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

    $editor.froalaEditor({
      enter: $.FroalaEditor.ENTER_BR,
      heightMax: 300,
      heightMin: 300,
      imageEditButtons: [
        'imageDisplay',
        'imageAlign',
        'imageInfo',
        'removeImage'
      ],
      placeholderText: 'Description',
      tabSpaces: 4,
      toolbarButtons: toolbarProps,
      toolbarButtonsMD: toolbarProps,
      toolbarButtonsSM: toolbarProps,
      toolbarButtonsXS: toolbarProps,
      toolbarSticky: false
    });

    $editor.froalaEditor(`edit.${this.props.editable}`);
  }

  componentWillUnmount() {
    $(`textarea#${this.props.id}`).froalaEditor('destroy');
  }

  render() {
    const {className, ...props} = this.props;

    return (
      <div className={className}>
        <textarea {...props}/>
      </div>
    );
  }
}

export default Textarea;
