let chatAreaTop = document.getElementById("chat-area-top");
let chatAreaTips = document.getElementById("chat-area-tips");
const socket = io("ws://127.0.0.1:8089");

$(function () {
  var uname = null;

  $(".login-btn").click(function () {
    uname = $.trim($("#loginName").val());
    if (uname) {
      /*向服务端发送登录事件*/
      socket.emit("login", { username: uname });
    } else {
      alert("请输入昵称");
    }
  });

  socket.on("loginSuccess", function (data) {
    if (data.username === uname) {
      checkin(data);
      var $alramDiv;
      //判断报警提示alarmDiv是否存在，如果不存在，则初始化
      if ($("#alarmDiv").length > 0) {
        $alramDiv = $("#alarmDiv");
      } else {
        $alramDiv = $('<div id="alarmDiv"></div>').appendTo($(document.body));
      }
      //清空报警对象，防止多次刷新后造成多次播放
      $alramDiv.empty();
      $(
        '<bgsound src="/home/yhfandmxq/webServer/public/static/music/login.mp3" loop="1">'
      ).appendTo($alramDiv);
    } else {
      alert("用户名不匹配，请重试");
    }
  });
  function checkin(data) {
    $(".login-wrap").hide("slow");
    $(".chat-wrap").show("slow");
  }

  socket.on("loginFail", function () {
    alert("昵称重复");
  });

  socket.on("add", function (data) {
    chatAreaTop.appendChild(
      getNoticeComponent(
        "1、 群组人员应以互相尊重，互相理解为基础文明聊天，遵守网络文明和为人之道德,2、 群友之间不得互相恶意攻击、漫骂。共同营造一个和谐、友好、融洽的交流，娱乐空间。3、 不得发布任何进行污蔑、诽谤和人身攻击的言论，不得进行地域攻击言论。4、 群聊，私聊均不得恶意骚扰女士。5、 讨论问题允许百家争鸣，讨论过程中发生争执，务请各方克制，就事论事，禁止使用过激的语言 ，和不当行为。 6、 不得利用本群聊天窗口做广告发布网站网址信息为己私利或污染视听！可以私下交流但禁止在群 聊里出现！ 7、 不得发布对政治攻击言论，不得发布传播无根据的容易引起社会恐慌的消息。 8、不允许聊不健康的内容,但因本群为成人群,允许开玩笑(须把握尺度),不允许发布色情连接、色情 网站、还有色情图片，将严重污染群内环境，违者视情节轻重论处，性质严重者直接清除。特别强调：群里严禁谈论色情、淫秽和政治性话题，管理必须严格监督，群里人员须自觉遵守， 否则坚决踢出。"
      )
    );
    chatAreaTips.appendChild(getTipsComponent(data.username + "已进入群聊"));
  });

  socket.on("leave", function (name) {
    if (name != null) {
      chatAreaTips.appendChild(getTipsComponent(name + "退出群聊"));
    }
  });
  $(".sendBtn").click(function () {
    sendMessage();
  });
  $(document).keydown(function (event) {
    if (event.keyCode == 13) {
      sendMessage();
    }
  });
  function sendMessage() {
    var txt = $("#sendtxt").val();
    $("#sendtxt").val("");
    if (txt) {
      socket.emit("sendMessage", { username: uname, message: txt });
    }
  }

  socket.on("receiveMessage", function (data) {
    showMessage(data);
  });

  function showMessage(data) {
    var html;
    if (data.username === uname) {
      html =
        '<div class="chat-item item-right clearfix"><span class="img fr"></span><span class="message fr">' +
        data.message +
        "</span></div>";
    } else {
      html =
        '<div class="chat-item item-left clearfix rela"><span class="abs uname">' +
        data.username +
        '</span><span class="img fl"></span><span class="fl message">' +
        data.message +
        "</span></div>";
    }
    $(".chat-con").append(html);
  }
});
