import Cookies from "js-cookie";

const TokenKey = "vue_admin_template_token";
const GuidKey = "vue_admin_template_guid";

export function getToken() {
  return Cookies.get(TokenKey);
}

export function setToken(token) {
  return Cookies.set(TokenKey, token);
}

export function removeToken() {
  return Cookies.remove(TokenKey);
}

export function getGuid() {
  return Cookies.get(GuidKey);
}

export function setGuid(guid) {
  return Cookies.set(GuidKey, guid);
}

export function removeGuid() {
  return Cookies.remove(GuidKey);
}
