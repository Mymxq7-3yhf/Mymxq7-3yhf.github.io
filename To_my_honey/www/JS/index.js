//获取必要元素
let dotsParent = document.getElementById("dots");
let dotArr = document.getElementsByClassName("dot");
let jiantouLeft = document.getElementsByClassName("jiantouLeft");
let jiantouRight = document.getElementsByClassName("jiantouRight");
let img = document.getElementById("imgId");

//数据抽象
let data = {
  imgsArr: [
    "./IMG/1.jpg",
    "./IMG/2.jpg",
    "./IMG/3.jpg",
    "./IMG/4.png",
    "./IMG/5.jpg",
  ],
  currentIndex: 0,
  currentDotBackColor: "red",
};

//页面渲染
function render() {
  let currentIndex = data.currentIndex;
  let currentDotBackColor = data.currentDotBackColor;
  let imgsArr = data.imgsArr;

  img.setAttribute("src", imgsArr[currentIndex]);
  dotArr[currentIndex].style.backgroundColor = currentDotBackColor;
}

//设置数据
function setData(keyName, value) {
  data[keyName] = value;
  render();
}

//设置句柄
document.body.onload = render;
dotsParent.onclick = function (e) {
  setData("currentDotBackColor", "pink");
  setData("currentIndex", Number(e.target.getAttribute("index")));
  setData("currentDotBackColor", "red");
};

jiantouLeft[0].onclick = function () {
  setData("currentDotBackColor", "pink");
  setData("currentIndex", maxMin(data.currentIndex - 1, 4, 0));
  setData("currentDotBackColor", "red");
};

jiantouRight[0].onclick = function () {
  setData("currentDotBackColor", "pink");
  setData("currentIndex", maxMin(data.currentIndex + 1, 4, 0));
  setData("currentDotBackColor", "red");
};

let timer = setInterval(function () {
  setData("currentDotBackColor", "pink");
  setData("currentIndex", maxMin(data.currentIndex + 1, 4, 0));
  setData("currentDotBackColor", "red");
}, 1500);

img.onmouseover = dotsParent.onmouseover = jiantouLeft[0].onmouseover = jiantouRight[0].onmouseover = function () {
  clearInterval(timer);
};
img.onmouseout = dotsParent.onmouseout = jiantouLeft[0].onmouseout = jiantouRight[0].onmouseout = function () {
  timer = setInterval(function () {
    setData("currentDotBackColor", "pink");
    setData("currentIndex", maxMin(data.currentIndex + 1, 4, 0));
    setData("currentDotBackColor", "red");
  }, 3000);
};

// 辅助/功能性函数
function maxMin(value, max, min) {
  let res = value;
  if (value > max) {
    res = min;
  }
  if (value < min) {
    res = max;
  }
  return res;
}
