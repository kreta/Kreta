/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/components/_textarea';

import React from 'react';

class Textarea extends React.Component {
  static propTypes = {
    editable: React.PropTypes.bool.isRequired,
    id: React.PropTypes.string.isRequired,
    value: React.PropTypes.string
  };

  componentDidUpdate() {
    const toolbarElements = true === this.props.editable
      ? 'bold italic underline link image styleselect strikethrough alignment bullist numlist separator'
      : false;

    tinymce.init({
      content_css: '/css/tinycme.css',
      forced_root_block: false,
      force_br_newlines: true,
      force_p_newlines: false,
      selector: `#${this.props.id}`,
      height: 300,
      menubar: false,
      plugins: 'autolink image link lists noneditable',
      style_formats: [
        {title: 'normal', block: 'div'},
        {title: 'code', inline: 'code'},
        {title: 'h1', block: 'h1'},
        {title: 'h2', block: 'h2'},
        {title: 'h3', block: 'h3'},
        {title: 'h4', block: 'h4'}
      ],
      setup: (editor) => {
        editor.on('keydown', function (event) {
          if (event.keyCode === 9) {
            if (event.shiftKey) {
              tinymce.execCommand('Outdent');
            } else {
              tinymce.execCommand('Indent');
              // tinymce.execCommand('mceInsertContent', false, '&nbsp;&nbsp;&nbsp;&nbsp;');
            }
            event.preventDefault();

            return false;
          }
        });
        editor.addButton('alignment', {
          type: 'listbox',
          text: false,
          icon: 'aligncenter',
          onselect: function () {
            tinymce.execCommand(this.value());
          },
          values: [
            {icon: 'alignleft', value: 'JustifyLeft'},
            {icon: 'alignright', value: 'JustifyRight'},
            {icon: 'aligncenter', value: 'JustifyCenter'},
            {icon: 'alignjustify', value: 'JustifyFull'}
          ],
          onPostRender: function () {
            this.value('JustifyLeft');
          }
        })
      },
      statusbar: false,
      toolbar: toolbarElements
    });
    document.getElementById('mceu_5-open').querySelector('span').innerHTML = 'P';
  }

  render() {
    const
      {className, editable, value, ...props} = this.props,
      editableClass = editable === true ? 'mceEditable' : 'mceNonEditable',
      content = `<div class=${editableClass}>${value}</div>`;

    return (
      <div className={className}>
        <textarea value={content} {...props}/>
      </div>
    );
  }
}

export default Textarea;
