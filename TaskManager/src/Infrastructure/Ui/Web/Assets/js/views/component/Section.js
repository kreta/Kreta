import React from 'react';

import SectionHeader from './SectionHeader';

export default props => {
  return (
    <section className="section">
      <SectionHeader title={props.title} actions={props.action}/>
      <div className="section__content">
        {props.children}
      </div>
    </section>
  );
};
