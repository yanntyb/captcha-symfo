const Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/app.js')
    .enableStimulusBridge('./assets/controllers.json')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabel((config) => {
        config.plugins.push('@babel/plugin-proposal-class-properties');
    })
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })
    .enableSassLoader()
    .enableTypeScriptLoader()
    .copyFiles([
        {from: './node_modules/ckeditor/', to: '../bundles/fosckeditor/[path][name].[ext]', pattern: /\.(js|css)$/, includeSubdirectories: false},
        {from: './node_modules/ckeditor/adapters', to: '../bundles/fosckeditor/adapters/[path][name].[ext]'},
        {from: './node_modules/ckeditor/lang', to: '../bundles/fosckeditor/lang/[path][name].[ext]'},
        {from: './node_modules/ckeditor/plugins', to: '../bundles/fosckeditor/plugins/[path][name].[ext]'},
        {from: './node_modules/ckeditor/skins', to: '../bundles/fosckeditor/skins/[path][name].[ext]'},
        {from: './node_modules/ckeditor/vendor', to: '../bundles/fosckeditor/vendor/[path][name].[ext]'}
    ])
;

module.exports = Encore.getWebpackConfig();
