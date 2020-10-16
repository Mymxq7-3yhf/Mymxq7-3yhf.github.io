const config = {
  http: require("http"),
  fs: require("fs"),
  mime: require("mime"),
  querystring: require("querystring"),
  indexArr: ["/login.html", "/static/js/index.js", "/static/css/index.css"],
  wwwroot: "/home/yhfandmxq/yhf/public",
  url: require("url"),
  errorOuts: {
    404: "/home/yhfandmxq/yhf/error/404.html",
    403: "/home/yhfandmxq/yhf/error/403.html",
  },
};

module.exports = config;
