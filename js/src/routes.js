import React from 'react';
import { Route } from 'react-router-dom';
import { Permissions, People } from './screens';

const Routes = [
  ['/admin/people/permissions', Permissions],
  ['/admin/people', People],
].map(([route, component]) => (
  <Route key={route} path={route} component={component} />
));

export default Routes;
