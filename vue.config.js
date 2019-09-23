const path = require('path')
const resolve = file => path.resolve(__dirname, file)
const isProd = process.env.NODE_ENV === 'production'

const assetsDir = 'vue'

module.exports = {
  publicPath: '/',
  assetsDir: assetsDir,
  outputDir: isProd ? 'dist/public' : 'src/public',
  filenameHashing: false,
  css: {
    extract: true,
    sourceMap: !isProd
  },
  devServer: {
    headers: { 'Access-Control-Allow-Origin': '*' },
    disableHostCheck: true
  },
  productionSourceMap: !isProd,
  transpileDependencies: [],
  configureWebpack: config => ({
    entry: './src/vue/main.js',
    target: 'web',
    plugins: []
  }),
  chainWebpack: config => {
    config.resolve.alias
      .set('@', resolve('src/vue'))
      .set('@assets', resolve('src/vue/assets'))

    config.plugins.delete('html')
    config.plugins.delete('preload')
    config.plugins.delete('prefetch')

    config.output
      .filename(assetsDir + '/js/[name].js')
      .hotUpdateChunkFilename(assetsDir + '/hot/hot-update.js')
      .hotUpdateMainFilename(assetsDir + '/hot/hot-update.json')
      .end()
  }
}
