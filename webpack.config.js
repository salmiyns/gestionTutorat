var Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
      // CSS FILES
    .addStyleEntry('bootstrap', './assets/css/bootstrap.min.css')
    .addStyleEntry('atlantisCss', './assets/css/atlantis.css')
    .addStyleEntry('atlantisCss2', './assets/css/atlantis.css')

    .addStyleEntry('fonts', './assets/css/fonts.min.css')



    .addEntry('app', './assets/js/app.js')
    .addEntry('jquery', './assets/js/core/jquery.3.2.1.min.js')
    .addEntry('popperjs', './assets/js/core/popper.min.js')
    .addEntry('webfont', './assets/js/plugin/webfont/webfont.min.js')
    .addEntry('jquery-ui', './assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')
    .addEntry('jquery-ui-touch-punch', './assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')
    .addEntry('atlantis', './assets/js/atlantis.js')

    
    //.addEntry('datatables', './assets/js/plugin/datatables/datatables.min.js')
    //.addEntry('datatable', './assets/js/datatable.js')
    //.addEntry('dataTables.bootstrap4', './assets/js/dataTables.bootstrap4.min.js')

    //.addEntry('page1', './assets/js/page1.js')
    //.addEntry('page2', './assets/js/page2.js')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    //.enableSingleRuntimeChunk()
    .disableSingleRuntimeChunk()
    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    // enables Sass/SCSS support
    //
    .enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()

    // uncomment if you use API Platform Admin (composer req api-admin)
    //.enableReactPreset()
    //.addEntry('admin', './assets/js/admin.js')
;

module.exports = Encore.getWebpackConfig();
