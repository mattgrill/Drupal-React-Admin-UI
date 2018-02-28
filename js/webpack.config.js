const path = require('path');
const components = require('./_tooling/components');

const webpack = require('webpack');

const envPlugins =
  process.env.NODE_ENV === 'production'
    ? [
        new webpack.DefinePlugin({
          'process.env.NODE_ENV': JSON.stringify('production'),
        }),
      ]
    : [new webpack.SourceMapDevToolPlugin()];

const config = {
  entry: {},
  output: {
    path: path.resolve(__dirname, 'dist'),
    filename: '[name].js',
  },
  externals: {
    react: 'React',
    'react-dom': 'ReactDOM',
  },
  optimization: {
    minimize: true,
    splitChunks: {
      chunks: 'all',
      minSize: 100,
      name: 'common.chunk',
      cacheGroups: {
        vendor: {
          name: 'vendor.chunk',
          test: /[\\/]node_modules[\\/]/,
        },
      },
    },
  },
  plugins: [...envPlugins],
  module: {
    rules: [
      {
        test: /\.js$/,
        loader: 'babel-loader',
        exclude: ['/node_modules/'],
        query: {
          plugins: [
            'external-helpers',
            'transform-class-properties',
            'transform-object-rest-spread',
          ],
          presets: [
            '@babel/preset-react',
            [
              '@babel/preset-env',
              {
                modules: false,
                targets: {
                  browsers: [
                    'chrome >= 62',
                    'edge >= 15',
                    'fireFox >= 56',
                    'safari >= 11',
                    'opera >= 47',
                  ],
                },
              },
            ],
          ],
        },
      },
    ],
  },
};

components().forEach(({ componentPath, componentName }) => {
  config.entry[componentName] = componentPath;
});

module.exports = config;
