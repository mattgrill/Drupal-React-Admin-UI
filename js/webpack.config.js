const path = require('path');
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
  entry: { app: './src/app.js' },
  output: {
    publicPath: '/modules/drupal-admin-ui/js/dist/',
    path: path.resolve(__dirname, 'dist'),
    filename: '[name].js',
    chunkFilename: '[name].js',
  },
  externals: {
    react: 'React',
    'react-dom': 'ReactDOM',
  },
  plugins: [
    new webpack.optimize.CommonsChunkPlugin({
      name: 'common',
      filename: 'common.js',
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
          plugins: [
            '@babel/plugin-syntax-dynamic-import',
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

module.exports = config;
