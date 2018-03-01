import React from 'react';
import { Card } from 'drupal-react-components';
import { Link } from 'react-router-dom';

const Permissions = () => (
  <Card title="Permissions">
    <Link to="/admin/people">People</Link>
  </Card>
);

export default Permissions;
