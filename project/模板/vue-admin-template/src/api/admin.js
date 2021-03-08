import request from "@/utils/request";

//管理员增删改查
export function addData(data) {
  return request({
    url: "/addadmin", //后台接口
    method: "post",
    data
  });
}

export function deleteData(guid) {
  return request({
    url: "/deleteadmin",
    method: "post",
    params: { guid }
  });
}

export function editData(data) {
  return request({
    url: "/editadmin",
    method: "post",
    data
  });
}

export function getData(currentPage, maxPage) {
  return request({
    url: "/getadmin",
    method: "post",
    params: { currentPage, maxPage }
  });
}
