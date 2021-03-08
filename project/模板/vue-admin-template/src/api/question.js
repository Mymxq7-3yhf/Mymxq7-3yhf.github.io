import request from "@/utils/request";

//题目(增删改查)
export function addData(content, type, guid) {
  //传给后台的数据
  return request({
    url: "/addquestion", //后台接口
    method: "post",
    params: { content, type, guid }
  });
}

export function deleteData(guid) {
  return request({
    url: "/deletequestion",
    method: "post",
    params: { guid }
  });
}

export function editData(data) {
  return request({
    url: "/editquestion",
    method: "post",
    data
  });
}

export function getData(currentPage, maxPage) {
  return request({
    url: "/getquestion",
    method: "post",
    params: { currentPage, maxPage }
  });
}
