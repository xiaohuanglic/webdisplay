module.exports = {
  // 基本路径 baseURL已经过时
  publicPath: './',  
  // 输出文件目录
  outputDir: 'dist',
  // eslint-loader 是否在保存的时候检查
  lintOnSave: true,
  // use the full build with in-browser compiler?
  // https://vuejs.org/v2/guide/installation.html#Runtime-Compiler-vs-Runtime-only
  // compiler: false,
  // webpack配置
  // see https://github.com/vuejs/vue-cli/blob/dev/docs/webpack.md
  chainWebpack: () => {},
  configureWebpack: () => {},
  // vue-loader 配置项
  // https://vue-loader.vuejs.org/en/options.html
  // vueLoader: {},
  // 生产环境是否生成 sourceMap 文件
  productionSourceMap: true,
  // css相关配置
  css: {
   // 是否使用css分离插件 ExtractTextPlugin
   extract: true,
   // 开启 CSS source maps?
   sourceMap: false,
   // css预设器配置项
   loaderOptions: {},
   // 启用 CSS modules for all css / pre-processor files.
   modules: false
   loaderOptions: {
        postcss: {
          plugins: [
              require('postcss-plugin-px2rem')({
                  rootValue: 75, //换算基数， 默认100  ，这样的话把根标签的字体规定为1rem为50px,这样就可以从设计稿上量出多少个px直接在代码中写多上px了。
                  // unitPrecision: 5, //允许REM单位增长到的十进制数字。
                  //propWhiteList: [],  //默认值是一个空数组，这意味着禁用白名单并启用所有属性。
                  // propBlackList: [], //黑名单
                  exclude: /(node_module)/, //默认false，可以（reg）利用正则表达式排除某些文件夹的方法，例如/(node_module)\/如果想把前端UI框架内的px也转换成rem，请把此属性设为默认值
                  // selectorBlackList: [], //要忽略并保留为px的选择器
                  // ignoreIdentifier: false,  //（boolean/string）忽略单个属性的方法，启用ignoreidentifier后，replace将自动设置为true。
                  // replace: true, // （布尔值）替换包含REM的规则，而不是添加回退。
                  mediaQuery: false, //（布尔值）允许在媒体查询中转换px。
                  minPixelValue: 3 //设置要替换的最小像素值(3px会被转rem)。 默认 0
              }),
          ]
      }
    }

  },
  // use thread-loader for babel & TS in production build
  // enabled by default if the machine has more than 1 cores
  parallel: require('os').cpus().length > 1,
  // 是否启用dll
  // See https://github.com/vuejs/vue-cli/blob/dev/docs/cli-service.md#dll-mode
  // dll: false,
  // PWA 插件相关配置
  // see https://github.com/vuejs/vue-cli/tree/dev/packages/%40vue/cli-plugin-pwa
  pwa: {},
  // webpack-dev-server 相关配置
  devServer: {
    open: process.platform === 'darwin',
    disableHostCheck: true,
    host: 'http://localhost:8081/',//如果是真机测试，就使用这个IP
    port: 8081,
    https: false,
    hotOnly: false,
   before: app => {}
  },
  // 第三方插件配置
  pluginOptions: {
   // ...
  }
 }
