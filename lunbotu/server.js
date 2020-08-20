const http = require("http");
const fs = require("fs");
//request = req
//response = res
//res.*可到文档找寻response.*

//定义一个网页根路径
var documentRoot = "/home/yhfmxq/studyNotes/8-20/www";

var server = http.createServer(function (request, response) {
  //用户输入的地址
  var url = request.url;

  var file = documentRoot + url;

  fs.readFile(file, function (err, data) {
    if (err) {
      response.writeHead(404, {
        "Content-Type": "text/html",
      });
      response.write("页面不存在");
      response.end();
    } else {
      response.writeHead(200);
      response.write(data); //将index.html显示在客户端
      response.end();
    }
  });
});
server.listen(8080);
console.log("服务开启成功");
