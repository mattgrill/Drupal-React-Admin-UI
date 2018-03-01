import React from 'react';
import { render } from 'react-dom';
import { BrowserRouter as Router, Route, Switch } from 'react-router-dom';

import { Permissions, People } from './screens';

const App = () => (
  <Router>
    <Switch>
      <Route path="/admin/people/permissions" component={Permissions} />
      <Route path="/admin/people" component={People} />
    </Switch>
  </Router>
);

render(<App />, document.getElementById('root'));
