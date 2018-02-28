const path = require('path');
const webpack = require('webpack');
const sharedWebPackConfig = require('./_tooling/shared.webpack.config');
const components = require('./_tooling/components');

const config = components().map(component => {
  const { filename, entry } = component;
  return Object.assign(
    {},
    { entry, output: { filename, path: path.resolve(__dirname, 'dist') } },
    sharedWebPackConfig,
    {
      plugins: [
        new webpack.DefinePlugin({
          'process.env': { NODE_ENV: JSON.stringify('development') },
        }),
      ],
      externals: {},
    },
  );
});

module.exports = config;
