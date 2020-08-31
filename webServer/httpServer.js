//引入模块

const Http = require("http");

const Fs = require("fs");

const Mime = require("mime");

const Qs = require("querystring");

//引入配置文件

const { wwwroot, errorOuts, indexArr } = require("./config.js");

const Router = require("./router.js");

let request = null;

let response = null;

let server = Http.createServer();

//建立事件与句柄关系

server.on("request", requestHandle);

function requestHandle(req, res) {
  request = req;

  response = res;

  request.params = { get: null, post: null }; //get请求

  request.params.get = Qs.parse(req.url.split("?")[1]); //post请求

  request.params.post = "";

  req.on("data", function (chunk) {
    request.params.post += chunk;
  });

  req.on("end", function () {
    request.params.post = Qs.parse(request.params.post); //找、读、返

    let pathObj = findPath(req.url.split("?")[0]);

    let dataObj = readFile(pathObj.path, pathObj.funName);

    writeFile(dataObj, pathObj.code);
  });
}

//找函数

function findPath(path) {
  let result = { path: "", code: 200 }; //引入路由模块

  if (Router[path]) {
    result.path = Router[path].split("@")[0];

    result.code = 200;

    result.funName = Router[path].split("@")[1];

    return result;
  }

  let truePath = wwwroot + path;

  if (!Fs.existsSync(truePath)) {
    return { path: errorOuts[404], code: 404 };
  }

  if (!Fs.statSync(truePath).isFile()) {
    return findIndex(truePath);
  }

  return { path: truePath, code: 200 };
}

//读函数

function readFile(path, funName = null) {
  let resObj = { data: "", fileType: "" };

  let arrTmp = path.split(".");

  let arr = arrTmp[arrTmp.length - 1];

  if (arr == "js" && request.params.get.api && funName) {
    resObj.data = require(path)[funName](request);

    delete require.cache[path];

    resObj.type = Mime.getType("json");

    return resObj;
  }

  resObj.data = Fs.readFileSync(path);

  resObj.type = Mime.getType(arr);

  return resObj;
}

//返函数

function writeFile(dataObj, code) {
  response.writeHead(code, {
    "Content-Type": dataObj.fileType,
  });

  response.write(dataObj.data);

  response.end();
}

function findIndex(path) {
  path =
    path[path.length - 1] == "/" ? path.substring(0, path.length - 1) : path;

  console.log(path);

  for (let i = 0; i < indexArr.length; i++) {
    let newPath = path + indexArr[i];

    if (Fs.existsSync(newPath)) {
      return { path: newPath, code: 200 };
    }
  }

  return { path: errorOuts[403], code: 403 };
}

// server.listen(7777, function () { });

module.exports = server;
