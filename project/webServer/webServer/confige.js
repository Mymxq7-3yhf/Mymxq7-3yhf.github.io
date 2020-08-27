const http = require("http");
const fs = require("fs");
const path = require("path");
const mime = require("mime");

const zdArr = ["index.html","1.jpg","2.jpg","3.jpg","4.jpg","5.jpg",]

const errorpages = {
    404: "/home/yhfandmxq/studyNotes/8-26/webServer/www/404.html",
    403: "/home/yhfandmxq/studyNotes/8-26/webServer/www/403.html",
    500: "/home/yhfandmxq/studyNotes/8-26/webServer/www/500.html",
  };


  module.exports.http = http;
  module.exports.fs = fs;
  module.exports.path = path;
  module.exports.mime = mime;
  module.exports.zdArr = zdArr;
  module.exports.errorpages = errorpages;