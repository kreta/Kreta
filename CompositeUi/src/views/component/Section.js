/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_section.scss';

import React from 'react';

const Section = props => (
  <section className="section">
    <div className="section__header">
      {props.header}
    </div>
    <div className="section__content">
      {props.children}
    </div>
  </section>
);

Section.propTypes = {
  header: React.PropTypes.object.isRequired,
};

export default Section;
