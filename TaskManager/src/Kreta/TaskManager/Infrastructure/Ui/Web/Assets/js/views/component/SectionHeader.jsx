import React from 'react';

import '../../../scss/components/_section-header.scss';

export default props => (
  <div className="section__header">
    <h3 className="section__header-title">
      {props.title}
    </h3>
    <div className="section__header-actions">
      {props.actions}
    </div>
  </div>
)
