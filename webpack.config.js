const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CopyPlugin = require('copy-webpack-plugin');

const js_dir = path.resolve(__dirname, 'assets/src/js');
const lib_dir = path.resolve(__dirname, 'assets/src/vendor');
const build_dir = path.resolve(__dirname, 'assets/build');

const entry = {
    frontend: js_dir + '/frontend.js'
};

const output = {
    path: build_dir,
    filename: 'js/[name].bundle.js', // [name].bundle_[contenthash].js
    clean: true, // clean previous js files
};

const plugins = [
    new MiniCssExtractPlugin({
        filename: 'css/[name].css'
    }),

    new CopyPlugin({
        patterns: [
            { from: lib_dir, to: build_dir + '/vendor' }
        ]
    }),
];

const rules = [
    {
        test: /\.js$/,
        include: [js_dir],
        exclude: /node_modules/,
        use: {
            loader: 'babel-loader',
            options: {
                presets: ['@babel/preset-env']
            }
        }
    },
    {
        test: /\.(s[ac]|c)ss$/,
        exclude: /node_modules/,
        use: [
            MiniCssExtractPlugin.loader,
            {
                loader: 'css-loader',
                options: { importLoaders: 1 },
            },
            {
                loader: 'postcss-loader',
                options: {
                    postcssOptions: {
                        plugins: [
                            ['autoprefixer'],
                        ],
                    },
                },
            },
            'sass-loader'
        ]
    },
    {
        test: /\.(ttf|otf|eot|svg|woff(2)?)(\?[a-z0-9]+)?$/,
        exclude: /node_modules/,
        type: 'asset/resource',
        generator: {
            filename: 'fonts/[name][ext]'
        }
    }
];

module.exports = (env) => ({
    // watch: 'development' === process.env.NODE_ENV ? true : false,
    entry: entry,
    output: output,
    devtool: 'development' === process.env.NODE_ENV ? 'source-map' : false,
    plugins: plugins,
    module: {
        rules: rules
    },
    externals: {
        jquery: 'jQuery'
    },
    devServer: {
        static: {
            directory: path.join(__dirname, 'assets/build'),
        },
        hot: true,
        compress: true,
        port: 9000,
        open: true,
        proxy: [
            {
                context: () => true, // Proxy svi zahtevi
                target: 'https://testtheme.test',
                secure: false, // Ako koristite samoopskrbljeni SSL certifikat
                changeOrigin: true,
            }
        ]
    },
    // plugins: [new webpack.HotModuleReplacementPlugin()]
});
