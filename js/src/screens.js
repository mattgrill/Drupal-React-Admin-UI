import React from 'react';
import Loadable from 'react-loadable';

const Loading = () => <p>loading...</p>;

const Permissions = Loadable({
  loader: () =>
    import(/* webpackChunkName: "permissions" */ './Screens/Permissions'),
  loading: Loading,
});

const People = Loadable({
  loader: () => import(/* webpackChunkName: "people" */ './Screens/People'),
  loading: Loading,
});

export { Permissions, People };
