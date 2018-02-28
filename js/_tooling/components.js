const dirTree = require('directory-tree');
const { children } = dirTree('./src/Components');

module.exports = () =>
  children.map(component => ({
    entry: `./${component.path}/index.js`,
    filename: `${component.name.toLowerCase()}.js`,
  }));
