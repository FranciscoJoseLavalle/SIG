const Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}


Encore
    // .addLoader({ test: /\.js$/, exclude: /node_modules/, loader: 'babel' })
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or subdirectory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './assets/app.js')
    // JQUERY
    // .addEntry('js/jquery', './node_modules/jquery/dist/jquery.min.js')
    // TEMPLATE SCRIPTS
    .addEntry('js/plugins.bundle', './assets/plugins/global/plugins.bundle.js')
    .addEntry('js/prismjs.bundle', './assets/plugins/custom/prismjs/prismjs.bundle.js')
    .addEntry('js/scripts.bundle', './assets/js/scripts.bundle.js')
    .addEntry('js/widgets', './assets/js/pages/widgets.js')
    // .addEntry('js/fullcalendar.bundle', './assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')
    // ESTILOS PROPIOS
    // .addStyleEntry('css/header', './assets/styles/header.css')
    // TEMPLATE STYLES
    .addStyleEntry('css/style.bundle', './assets/css/style.bundle.css')
    // .addStyleEntry('css/fullcalendar.bundle', './assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')
    .addStyleEntry('css/plugins.bundle', './assets/plugins/global/plugins.bundle.css')
    .addStyleEntry('css/prismjs.bundle', './assets/plugins/custom/prismjs/prismjs.bundle.css')
    .addStyleEntry('css/themes/lightBase', './assets/css/themes/layout/header/base/light.css')
    .addStyleEntry('css/themes/lightMenu', './assets/css/themes/layout/header/menu/light.css')
    .addStyleEntry('css/themes/darkBrand', './assets/css/themes/layout/brand/dark.css')
    .addStyleEntry('css/themes/darkAside', './assets/css/themes/layout/aside/dark.css')
    // LOGIN STYLES
    .addStyleEntry('css/login/login', './assets/css/pages/login/classic/login-5.css')
    // DATATABLES STYLES
    // .addStyleEntry('css/datatables/datatables.bundle', './assets/plugins/custom/datatables/datatables.bundle.css')
    // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
    .enableStimulusBridge('./assets/controllers.json')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .enableBuildNotifications()
    // enables hashed filenames (e.g. app.abc123.css)
    .cleanupOutputBeforeBuild()
    .enableVersioning(Encore.isProduction())
    .enableSourceMaps(!Encore.isProduction())

    // configure Babel
    // .configureBabel((config) => {
    //     config.plugins.push('@babel/a-babel-plugin');
    // })

    // enables and configure @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })

    // enables Sass/SCSS support
    // .enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you use React
    //.enableReactPreset()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()
    ;

module.exports = Encore.getWebpackConfig();