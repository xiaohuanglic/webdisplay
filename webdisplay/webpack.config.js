const path = require('path')
var HtmlWebpackPlugin = require('html-webpack-plugin');
var webpack = require('webpack')
const VueLoaderPlugin = require('vue-loader/lib/plugin')
module.exports={
	entry:path.join(__dirname,'./src/index.js'),// 入口
	output:{
		path:path.join(__dirname,'./dist'),
		filename:"bundle.js"
	},
	devServer: {
    contentBase:'src',
    open:true,
    // compress: true,
    port: 8081
  },
   module: {
    rules: [

      {
        test: /\.css$/,
        use: [ 'style-loader', 'css-loader']
      },
      {test: /\.(png|jpg|gif)$/i,
      	// use:['url-loader?limit=0&name=[hash:8]-[name].[ext]']
      	 loader: 'url-loader',
            options: {
              limit: 8000,
              name: '[hash:8]-[name].[ext]'
           }
      },
      {
      	test: /\.(ttf|svg|eot|woff|woff2)$/,
        use: [ 'url-loader']
      },
      {
        test: /\.php$/,
        loaders: [
          'html-minify',
          'php-loader'
        ]
      },
  	{
  		test: /\.m?js$/,
    	exclude: /(node_modules|bower_components)/,
    	use: {
      	loader: 'babel-loader',
      	options: {
        	presets: ['@babel/preset-env'],
        	plugins: ['@babel/plugin-transform-runtime','@babel/plugin-proposal-class-properties']
      	}
    }
  	},
  	{
  		test: /\.vue$/,
        loader: 'vue-loader'
  	},
    	
    ]
  },
 	// {
  resolve: {
      alias: {
         vue: 'vue/dist/vue.js'
      }
    },

	// },

  plugins: [new HtmlWebpackPlugin({
  	template: './src/index.html',
  	// 用作模板
  	filename: 'index.html'
  }), 

  new VueLoaderPlugin(),
  new webpack.ProvidePlugin({
        $: "jquery",
        jQuery: "jquery",
        jquery: "jquery",
        "window.jQuery": "jquery"
    }),

  ]


}