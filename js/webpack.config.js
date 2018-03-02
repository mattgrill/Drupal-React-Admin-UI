const path = require('path');
const webpack = require('webpack');
const Minify = require('babel-minify-webpack-plugin');

const envPlugins =
  process.env.NODE_ENV === 'production'
    ? [
        new webpack.DefinePlugin({
          'process.env.NODE_ENV': JSON.stringify('production'),
        }),
        new Minify(),
      ]
    : [];
// 'core-js/fn/promise', 'core-js/fn/object/entries',
const config = {
  entry: {
    app: ['./src/app.js'],
  },
  output: {
    publicPath: '/modules/drupal-admin-ui/js/dist/',
    path: path.resolve(__dirname, 'dist'),
    filename: '[name].js',
    chunkFilename: '[name].[hash].chunk.js',
  },
  plugins: [
    new webpack.optimize.CommonsChunkPlugin({
      name: 'vendor',
      minChunks: m => /node_modules/.test(m.context),
    }),
    ...envPlugins,
  ],
  module: {
    loaders: [
      {
        test: /\.js$/,
        loader: 'babel-loader',
        exclude: ['/node_modules/'],
        query: {
          cacheDirectory: true,
          plugins: [
            '@babel/plugin-syntax-dynamic-import',
            '@babel/plugin-external-helpers',
            '@babel/plugin-proposal-class-properties',
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

module.exports = config;
