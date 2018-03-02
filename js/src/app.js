import React from 'react';
import { render } from 'react-dom';
import { BrowserRouter as Router, Route, Switch } from 'react-router-dom';

import Routes from './routes';

const App = () => (
  <Router>
    <Switch>{Routes}</Switch>
  </Router>
);

render(<App />, document.getElementById('root'));
