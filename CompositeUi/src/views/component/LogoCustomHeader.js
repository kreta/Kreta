/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import React from 'react';

import './../../scss/components/_logo-custom-header.scss';
import LogoIcon from './../../svg/logo-green.svg';

import Icon from './Icon';
import {routes} from './../../Routes';

const LogoCustomHeader = props => (
  <div className="logo-custom-header">
    <a href={routes.home}>
      <Icon glyph={LogoIcon}/>
    </a>
    <h1 className="logo-custom-header__title">{props.title}</h1>
  </div>
);

export default LogoCustomHeader;
