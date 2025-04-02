const mix = require('laravel-mix');
const webpack = require('webpack');

mix.setPublicPath('public')
   .js('resources/js/app.js', 'public/js')
   .js('resources/js/animations.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
       require('tailwindcss'),
       require('autoprefixer'),
   ])
   // Copy images
   .copyDirectory('resources/images', 'public/images')
   .version();

// Disable manifest generation in development
if (!mix.inProduction()) {
    mix.webpackConfig({
        plugins: [
            new webpack.SourceMapDevToolPlugin({
                filename: '[file].map',
                exclude: /vendor/
            })
        ]
    });
}

{
    minimize: mix.inProduction() ? {
        collapseWhitespace: true,
        removeComments: true,
        removeRedundantAttributes: true,
        removeScriptTypeAttributes: true,
        removeStyleLinkTypeAttributes: true,
        useShortDoctype: true,
        minifyCSS: true,
        minifyJS: true,
        minifyURLs: true,
        removeEmptyAttributes: true
    } : false
}
