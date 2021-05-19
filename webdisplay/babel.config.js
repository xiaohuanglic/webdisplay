module.exports = function (api) {
  api.cache(true);

  const presets = [  ];// 类似.babelrc.js中的presets
  const plugins = [  ];// 类似.babelrc.js中的plugins

  return {
    presets,
    plugins
  };
}