import React from 'react';

import '../../../scss/components/_section.scss';

const Section = props => {
  return (
    <section className="section">
      <div className="section__header">
        <h3 className="section__header-title">
          {props.title}
        </h3>
        <div className="section__header-actions">
          {props.actions}
        </div>
      </div>
      <div className="section__content">
        {props.children}
      </div>
    </section>
  );
};

export default Section;
