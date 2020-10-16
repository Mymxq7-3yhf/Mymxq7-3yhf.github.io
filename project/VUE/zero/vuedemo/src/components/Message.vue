<template>
  <div>
    <div class="top">
      <h3>合同信息</h3>

      <div class="left">
        <div id="left"><h6>合同编号：ASX123123123123123</h6></div>
        <div id="left"><h6>联系人： 大张三</h6></div>
        <div id="left">
          <h6>
            合同类型：
            <div id="biaozhun">标准</div>
          </h6>
        </div>
        <div id="left">
          <h6>
            合同备注：<span
              >Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean
              euismod bibendum laoreet. Proin gravida dolor sit amet lacus
              accumsan et viverra justo commodo. Proin sodales pulvinar sic
              tempor. Sociis natoque penatibus et magnis dis parturient montes,
              nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra
              vulputate, felis tellus mollis orci, sed rhoncus pronin sapien
              nunc accuan eget.</span
            >
          </h6>
        </div>
      </div>

      <div class="right">
        <div id="right"><h6>公司名称：北京启思创实业有事公司</h6></div>
        <div id="right"><h6>联系电话： 13333333333</h6></div>
        <div id="right"><h6>合同状态：未生效</h6></div>
        <div id="right"><h6>业务员：张三的爸爸</h6></div>
      </div>
    </div>

    <div class="button">
      <h3>设备信息</h3>
      <table>
        <tr border="1" class="total" style="border-collapse:collapse;">
          <th>设备编号</th>
          <th>设备型号</th>
          <th>安装地址</th>
          <th>安装日期</th>
        </tr>
        <tr>
          <td>1111111</td>
          <td>A-110</td>
          <td>北京朝阳区三里屯 XX 火锅店</td>
          <td>2020-11-12 11:11</td>
        </tr>
        <tr>
          <td>2222222</td>
          <td>A-330</td>
          <td>北京朝阳区三里屯 XX 火锅店</td>
          <td>2020-11-12 11:11</td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script></script>

<style>
span {
  position: absolute;
  width: 290px;
  height: 171px;
  left: 55px;
}
tr th {
  font-weight: 700;
  font-style: normal;
  font-size: 16px;
}
.top {
  position: absolute;
  left: 50px;
  top: 99px;
  width: 1102px;
  height: 371px;
  border-radius: 5px;
  text-align: left;
}
.left {
  width: 551px;
  height: 371px;
}
.right {
  position: absolute;
  width: 551px;
  height: 371px;
  left: 500px;
  top: 50px;
}
.button {
  position: absolute;
  left: 50px;
  top: 500px;
  width: 1102px;
  height: 257px;
  border-radius: 5px;
  text-align: left;
}
.total {
  width: 950px;
  height: 93px;
  text-align: center;
}

#left {
  border-width: 0px;
  width: 223px;
  height: 20px;
}
#right {
  border-width: 0px;
  width: 223px;
  height: 20px;
}
#biaozhun {
  position: absolute;
  left: 60px;
  top: 160px;
  width: 70px;
  height: 30px;
  color: #008dff;
  background-color: #b3dcff;
  text-align: center;
  border-radius: 5px 5px 5px 5px;
  line-height: 30px;
}
#teshu {
  position: absolute;
  left: 60px;
  top: 160px;
  width: 70px;
  height: 30px;
  color: #f0f0f0;
  background-color: #9c9a9c;
  text-align: center;
  border-radius: 5px 5px 5px 5px;
  line-height: 30px;
}
</style>
