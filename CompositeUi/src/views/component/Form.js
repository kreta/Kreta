/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_form.scss';

import React from 'react';

const Form = props => {
  const {children, ...otherProps} = props;
  return (
    <form className="form" {...otherProps}>
      {children}
    </form>
  );
};

export default Form;

