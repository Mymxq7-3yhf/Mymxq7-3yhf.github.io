const getters = {
  sidebar: state => state.app.sidebar,
  device: state => state.app.device,
  token: state => state.user.token,
  guid: state => state.user.guid,
  img: state => state.user.img,
  nickname: state => state.user.nickname,
  id: state => state.user.id,
  rolename: state => state.user.rolename,
  password: state => state.user.password,

  status: state => state.user.status,
  addtime: state => state.user.addtime,
  lasttime: state => state.user.lasttime,
  ip: state => state.user.ip
};
export default getters;
