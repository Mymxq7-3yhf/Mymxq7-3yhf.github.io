import request from "@/utils/request";

export function login(data) {
  return request({
    url: "/login",
    method: "post",
    data
  });
}

export function getInfo(guid) {
  return request({
    url: "/info",
    method: "post",
    params: { guid }
  });
}

export function logout(guid) {
  return request({
    url: "/logout",
    method: "post",
    params: { guid }
  });
}

export function captcha() {
  return request({
    url: "/code/captcha/{tmp}",
    method: "get"
  });
}
