import React from 'react';
import { render } from 'react-dom';

import { PageTitle } from '../../Blocks';

const App = () => <PageTitle title="People" />;

render(<App />, document.getElementById('root'));
