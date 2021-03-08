import request from "@/utils/request";

//题目(增删改查)
export function addData(guid, data) {
  //传给后台的数据
  return request({
    url: "/addanswer", //后台接口
    method: "post",
    params: { guid, data }
  });
}

export function deleteData(id) {
  return request({
    url: "/deleteanswer",
    method: "post",
    params: { id }
  });
}

export function editData(data) {
  return request({
    url: "/editanswer",
    method: "post",
    data
  });
}

export function getData(currentPage, maxPage) {
  return request({
    url: "/getanswer",
    method: "post",
    params: { currentPage, maxPage }
  });
}

export function getQuestion(data) {
  return request({
    url: "/answergetquestion",
    method: "post",
    data
  });
}

export function getQuestionType(guid) {
  return request({
    url: "/answergetquestiontype",
    method: "post",
    params: { guid }
  });
}

export function changeData(data) {
  return request({
    url: "/answerchangedata",
    method: "post",
    data
  });
}
