import { login, logout, getInfo } from "@/api/user";
import {
  getToken,
  setToken,
  removeToken,
  getGuid,
  setGuid,
  removeGuid
} from "@/utils/auth";
import { resetRouter } from "@/router";

const getDefaultState = () => {
  return {
    token: getToken(),
    guid: getGuid(),
    name: "",
    avatar: ""
  };
};

const state = getDefaultState();

//将元素值传到getters.js
const mutations = {
  RESET_STATE: state => {
    Object.assign(state, getDefaultState());
  },
  SET_TOKEN: (state, token) => {
    state.token = token;
  },
  SET_GUID: (state, guid) => {
    state.guid = guid;
  },
  SET_NICKNAME: (state, nickname) => {
    state.nickname = nickname;
  },
  SET_IMG: (state, img) => {
    state.img = img;
  },
  SET_ROLENAME: (state, rolename) => {
    state.rolename = rolename;
  },
  SET_ID: (state, id) => {
    state.id = id;
  },
  SET_LOGINNAME: (state, loginname) => {
    state.loginname = loginname;
  },
  SET_STATUS: (state, status) => {
    state.status = status;
  },
  SET_ADDTIME: (state, addtime) => {
    state.addtime = addtime;
  },
  SET_LASTTIME: (state, lasttime) => {
    state.lasttime = lasttime;
  },
  SET_IP: (state, ip) => {
    state.ip = ip;
  }
};

const actions = {
  // user login
  login({ commit }, userInfo) {
    const { username, password, captcha } = userInfo; //解构
    return new Promise((resolve, reject) => {
      login({ username: username.trim(), password: password, captcha: captcha }) //api/uer.js  传数据到后台server
        .then(response => {
          let data = response.data; //要有data   拿后台返回的数据
          // console.log(response.data);
          commit("SET_TOKEN", data.token);
          commit("SET_GUID", data.guid);
          setToken(data.token);
          setGuid(data.guid);
          resolve();
        })
        .catch(error => {
          reject(error);
        });
    });
  },

  // get user info
  getInfo({ commit, state }) {
    return new Promise((resolve, reject) => {
      getInfo(state.guid) //通过api/user对应的请求将数据传到后台
        .then(response => {
          //接受后台返回的数据请求
          let data = response.data;

          if (!data) {
            return reject("Verification failed, please Login again.");
          }

          const { nickname, img, id, rolename } = data; //将后台拿到的数据解构赋值
          commit("SET_NICKNAME", nickname);
          commit("SET_IMG", img);

          commit("SET_ID", id);
          commit("SET_ROLENAME", rolename);
          resolve(data);
        })
        .catch(error => {
          reject(error);
        });
    });
  },

  // user logout
  logout({ commit, state }) {
    return new Promise((resolve, reject) => {
      logout(state.guid)
        .then(() => {
          removeToken(); // must remove  token  first
          resetRouter();
          commit("RESET_STATE");
          resolve();
        })
        .catch(error => {
          reject(error);
        });
    });
  },

  // remove token
  resetToken({ commit }) {
    return new Promise(resolve => {
      removeToken(); // must remove  token  first
      commit("RESET_STATE");
      resolve();
    });
  },
  //remove guid
  resetGuid({ commit }) {
    return new Promise(resolve => {
      removeGuid(); // must remove  guid  first
      commit("RESET_STATE");
      resolve();
    });
  }
};

export default {
  namespaced: true,
  state,
  mutations,
  actions
};
