import Loadable from 'react-loadable';

import Loading from './Helpers/loading';

const Permissions = Loadable({
  loader: () => import('./Screens/Permissions'),
  loading: Loading,
});

const People = Loadable({
  loader: () => import('./Screens/People'),
  loading: Loading,
});

export { Permissions, People };
