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

import './../../scss/components/_logo-header.scss';
import LogoFullIcon from './../../svg/logo-full.svg';

import Icon from './Icon';

const LogoHeader = () =>
  <div className="logo-header">
    <Icon glyph={LogoFullIcon} />
  </div>;

export default LogoHeader;
