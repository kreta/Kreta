/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_form-input-file';
import ImageIcon from './../../svg/image';

import React from 'react';

import Icon from './../component/Icon';

class FormInputFile extends React.Component {
  static propTypes = {
    filename: React.PropTypes.string
  };

  componentWillMount() {
    this.setState({
      filename: this.props.filename ? this.props.filename : '',
      value: this.props.value ? this.props.value : ''
    });
  }

  onChange(event) {
    const file = event.target.files[0];

    if (typeof file === 'undefined') {
      this.setState({filename: this.props.filename ? this.props.filename : ''});
    } else {
      this.setState({filename: window.URL.createObjectURL(file)});
    }
  }

  renderImageElement() {
    if (this.state.filename === '') {
      return '';
    }

    return (
      <img className="form-input-file__image" src={this.state.filename}/>
    );
  }

  render() {
    return (
      <div className="form-input-file">
        <label htmlFor="form-input-file">
          <div className="form-input-file__image-container">
            <div
              className={`form-input-file__background ${this.state.filename !== ''
                ? 'form-input-file__background--hidden'
                : ''}`}>
              <Icon color="white" glyph={ImageIcon}/>
            </div>
            {this.renderImageElement()}
          </div>
        </label>
        <input className="form-input-file__input"
               defaultValue=""
               id="form-input-file"
               name={this.props.name}
               onChange={this.onChange.bind(this)}
               type="file"/>
      </div>
    );
  }
}

export default FormInputFile;
