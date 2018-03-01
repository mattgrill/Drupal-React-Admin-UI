import React from 'react';
import { Card } from 'drupal-react-components';
import { Link } from 'react-router-dom';

const People = () => (
  <Card title="People">
    <Link to="/admin/people/permissions">Permissions</Link>
  </Card>
);

export default People;
