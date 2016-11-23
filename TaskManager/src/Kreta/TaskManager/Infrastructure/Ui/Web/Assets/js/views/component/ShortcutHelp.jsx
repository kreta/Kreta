import React from 'react';

import '../../../scss/components/_shortcut-help.scss';

export default props => (
  <div className="shortcut-help">
    <span className="shortcut-help__keyboard">{props.keyboard}</span>
    {props.does}
  </div>
)
