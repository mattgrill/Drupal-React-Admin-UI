import React, { Fragment } from 'react';

const Loading = ({ error }) => (
  <Fragment>{error ? <p>Error</p> : <p>Loading</p>}</Fragment>
);

export default Loading;
