import React from 'react';

import '../../../scss/components/_grid.scss';

const Row = props => {
  let classList = 'row';

  if(props.collapse) {
    classList = classList + ` row--collapse`;
  }

  if(props.center) {
    classList = classList + ' row--center';
  }

  return (
    <div className={classList}>
      {props.children}
    </div>
  );
};

const RowColumn = props => {
  let classList = 'row__column';

  if(props.small) {
    classList = classList + ` row__column--small-${props.small}`;
  }

  if(props.medium) {
    classList = classList + ` row__column--medium-${props.medium}`;
  }

  if(props.large) {
    classList = classList + ` row__column--large-${props.large}`;
  }

  return (
    <div className={classList}>
      {props.children}
    </div>
  );
};

export default {
  Row,
  RowColumn
};
