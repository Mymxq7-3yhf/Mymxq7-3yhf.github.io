//引入模块
const config = require("./config");
const Router = require("./router");

let server = config.http.createServer();

let request = null;
let response = null;

//建立事件
server.on("request", function (req, res) {
  request = req;

  response = res;
  //get请求
  request.params = { get: null, post: null };
  //post请求
  request.params.get = config.querystring.parse(req.url.split("?")[1]);

  request.params.post = "";

  req.on("data", function (chunk) {
    request.params.post += chunk;
  });

  req.on("end", function () {
    request.params.post = config.querystring.parse(request.params.post);

    //找
    let pathObj = findPath(req.url.split("?")[0]);
    //读
    let dataObj = readFile(pathObj.path, pathObj.funName);
    //返
    writeFile(dataObj, pathObj.code);
  });
});

//找函数
function findPath(path) {
  //引入路由模块
  let result = { path: "", code: 200 };
  path = path[0] === "/" ? path.split("/")[1] : path;
  //console.log(path);
  if (Router[path]) {
    result.path = Router[path].split("@")[0];

    result.code = 200;

    result.funName = Router[path].split("@")[1];
    return result;
  }

  let truePath = config.wwwroot + "/" + path;
  if (!config.fs.existsSync(truePath)) {
    return { path: config.errorOuts[404], code: 404 };
  }
  if (!config.fs.statSync(truePath).isFile()) {
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

    resObj.type = config.mime.getType("json");

    return resObj;
  }

  resObj.data = config.fs.readFileSync(path);

  resObj.type = config.mime.getType(arr);

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

  for (let i = 0; i < config.indexArr.length; i++) {
    let newPath = path + config.indexArr[i];

    if (config.fs.existsSync(newPath)) {
      return { path: newPath, code: 200 };
    }
  }

  return { path: config.errorOuts[403], code: 403 };
}

module.exports = server;
