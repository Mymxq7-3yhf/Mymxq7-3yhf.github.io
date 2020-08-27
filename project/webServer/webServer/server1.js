const  yhf = require("./confige.js")



let wwwroot = "/home/yhfandmxq/studyNotes/8-26/webServer/www/";


const server = yhf.http.createServer();
server.listen(8080, function () {
  console.log("Server running at http://127.0.0.1:8080/index.html");
});

server.on("request", function (req, res) {
  //找
  let url = zhao(req.url);
  console.log(req.url, "----", url);
  //读
  let dataObj = du(url);
  //返
  xiangying(dataObj, res);
});

function zhao(inUrl) {
  inUrl = inUrl[0] === "/" ? inUrl.substring(1) : inUrl;
  console.log( inUrl.substring(1))
  wwwroot =
    wwwroot[wwwroot.length - 1] === "/"
      ? wwwroot.substring(0, wwwroot.length - 1)
      : wwwroot;

  let url = wwwroot + "/" + inUrl;

  if (!puanduanAccess(url)) {
    return yhf.errorpages["403"];
  }

  if (!yhf.fs.existsSync(url)) {
    return yhf.errorpages["404"];
  }
//入口文件
if (!yhf.fs.statSync(url).isFile()) {
  let count = 0;
  yhf.zdArr.forEach(Url => {
    Url = Url[0] === "/" ? Url.substring(1) : Url; 
    let newUrl = wwwroot + "/" + Url;
    console.log(newUrl);
    if(yhf.fs.existsSync(newUrl)) {
      count++;
      url = newUrl;
    }
  })
  return url;
}
  return url;   
}


function puanduanAccess(url) {
  console.log(url);
  try {
    yhf.fs.accessSync(url, yhf.fs.constants.R_OK);
    return true;
  } catch (err) {
    return false;
  }
}

function du(url) {
  console.log(url);
  let dataObj = { data: "", type: "" };
  let extTmp = url.split(".");

  dataObj.data = yhf.fs.readFileSync(url);
  dataObj.type = yhf.mime.getType(extTmp[extTmp.length - 1]);

  return dataObj;
}

function xiangying(data, response) {
  response.writeHead(200, { "Content-Type": data.type });
  response.write(data.data);
  response.end();
}
