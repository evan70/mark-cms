const mix = require('laravel-mix');
const webpack = require('webpack');

mix.setPublicPath('public')
   .js('resources/assets/js/app.js', 'public/js')
   .js('resources/assets/js/animations.js', 'public/js')
   .postCss('resources/assets/css/app.css', 'public/css', [
       require('@tailwindcss/postcss'),
       require('autoprefixer'),
   ])
   // Copy images
   .copyDirectory('resources/assets/images', 'public/images')
   // Copy favicon
   .copyDirectory('resources/assets/favicon', 'public/assets/favicon')
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

// {
//     minimize: mix.inProduction() ? {
//         collapseWhitespace: true,
//         removeComments: true,
//         removeRedundantAttributes: true,
//         removeScriptTypeAttributes: true,
//         removeStyleLinkTypeAttributes: true,
//         useShortDoctype: true,
//         minifyCSS: true,
//         minifyJS: true,
//         minifyURLs: true,
//         removeEmptyAttributes: true
//     } : false
// }
