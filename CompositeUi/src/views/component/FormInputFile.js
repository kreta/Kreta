/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_form-input-file.scss';

import ImageIcon from './../../svg/image.svg';

import React from 'react';

import Icon from './../component/Icon';

class FormInputFile extends React.Component {
  static propTypes = {
    filename: React.PropTypes.string,
  };

  componentWillMount() {
    this.setState({
      filename: this.props.filename ? this.props.filename : '',
    });
  }

  onChange(event) {
    const {input: {onChange}} = this.props,
      file = event.target.files[0];

    if (typeof file === 'undefined') {
      this.setState({filename: this.props.filename ? this.props.filename : ''});
    } else {
      this.setState({filename: window.URL.createObjectURL(file)});
    }

    onChange(file);
  }

  renderImageElement() {
    if (!this.state.filename) {
      return (
        <div className="form-input-file__background">
          <Icon color="white" glyph={ImageIcon} />
        </div>
      );
    }

    return <img className="form-input-file__image" src={this.state.filename} />;
  }

  render() {
    const {input: {value}} = this.props;

    return (
      <label className="form-input-file">
        {this.renderImageElement()}
        <input
          className="form-input-file__input"
          onChange={this.onChange.bind(this)}
          type="file"
          value={value}
        />
      </label>
    );
  }
}

export default FormInputFile;
