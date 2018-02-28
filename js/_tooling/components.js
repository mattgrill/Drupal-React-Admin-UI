const dirTree = require('directory-tree');
const { children } = dirTree('./src/Screens');

module.exports = () =>
  children.map(component => ({
    componentPath: `./${component.path}/index.js`,
    componentName: `${component.name.toLowerCase()}`,
  }));
