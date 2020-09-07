<template>
  <div class="all">
    <div id="top">
      <h3 id="h3one">新建数据</h3>
      <h3 id="h3two">X</h3>
    </div>
    <div id="divone">
      <span style="color:red">*</span>客户公司名称 <input id="inputone" />
    </div>
    <div id="divtwo">
      <span style="color:red">*</span>联系人名字<input id="inputone" />
    </div>
    <div id="divthree">
      <span style="color:red">*</span>联系人手机号<input id="inputone" />
    </div>
    <div id="divfour">
      <span style="color:red">*</span>合同类型
      <select id="option">
        <option>请选择</option>
        <option>标准</option>
        <option>特殊</option>
      </select>
    </div>
    <div id="divfive">
      <span style="color:red">*</span>公司详细地址<input id="inputone" />
    </div>
    <div id="divsix">备注<input id="inputtwo" /></div>
    <div id="divseven">
      <span style="color:red">*</span>合同状态
      <select id="option">
        <option>请选择</option>
        <option>已生效</option>
        <option>未生效</option>
      </select>
    </div>
    <div id="diveight">
      <span style="color:red">*</span>业务员<input id="inputone" />
    </div>
    <div id="divnine">
      <span style="color:red">*</span>设备数量<input id="inputone" value="2" />
    </div>
    <div id="divten">
      <button id="quxiao">取消</button>
      <button id="queding">确定</button>
    </div>
  </div>
</template>
<script></script>

<style>
.all {
  position: absolute;
  left: 300px;
  top: 50px;
  width: 692px;
  height: 801px;
}

#top {
  width: 693px;
  height: 62px;
  background-color: #008aff;
}
#h3one {
  color: white;
  text-align: left;
  line-height: 27px;
  float: left;
  margin-left: 20px;
}
#h3two {
  color: white;
  text-align: right;
  line-height: 27px;
  float: right;
  margin-right: 20px;
}
#divone {
  position: absolute;
  left: 50px;
  top: 90px;
}
#inputone {
  position: absolute;
  width: 360px;
  height: 30px;
  font-size: 13px;
  margin-left: 20px;
}
#inputtwo {
  position: absolute;
  width: 360px;
  height: 63px;
  font-size: 13px;
  margin-left: 20px;
}
#divtwo {
  position: absolute;
  left: 67px;
  top: 150px;
}
#divthree {
  position: absolute;
  left: 50px;
  top: 210px;
}
#divfour {
  position: absolute;
  left: 80px;
  top: 270px;
}
#divfive {
  position: absolute;
  left: 50px;
  top: 330px;
}
#divsix {
  position: absolute;
  left: 120px;
  top: 390px;
}
#divseven {
  position: absolute;
  left: 80px;
  top: 473px;
}
#diveight {
  position: absolute;
  left: 97px;
  top: 533px;
}
#divnine {
  position: absolute;
  left: 80px;
  top: 593px;
}
#divten {
  position: absolute;
  left: 0px;
  top: 700px;
  background-color: #eeeeee;
  width: 692px;
  height: 56px;
  text-align: right;
  line-height: 56px;
}
#option {
  position: absolute;
  width: 300px;
  height: 30px;
  font-size: 13px;
  margin-left: 20px;
}
#quxiao {
  width: 140px;
  height: 40px;
  border-radius: 5px;
  background-color: #ffffff;
  color: #333333;
  line-height: 40px;
}
#queding {
  width: 140px;
  height: 40px;
  border-radius: 5px;
  background-color: #008aff;
  color: #effdff;
  line-height: 40px;
}
</style>
