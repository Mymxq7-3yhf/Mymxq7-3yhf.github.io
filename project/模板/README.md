## lumen + vue-element-admin

### 登陆页面梳理前后台

1. 前端登陆页面
   > vue-admin-template/src/views/login/index.vue

```
handleLogin() {
      this.$refs.loginForm.validate(valid => {
        if (valid) {
          this.loading = true;
          this.$store   //在根目录下的store
            .dispatch("user/login", this.loginForm)   //将表单的数据传到user/login
            .then(() => {
              this.$router.push({ path: this.redirect || "/" });
              this.loading = false;
            })
            .catch(() => {
              this.loading = false;
            });
        } else {
          console.log("error submit!!");
          return false;
        }
      });
    }
```

2. api 接受数据
   > vue-admin-template/src/api/user.js

```
export function login(data) {
  return request({
    // url: '/vue-admin-template/user/login',
    url: "/login",
    method: "post",
    data
  });
}
```

3. 前端发送请求
   > vue-admin-template/src/store/modules/user.js

```
import { login, logout, getInfo, register } from "@/api/user";  //请求一定要引进来
// user login
  login({ commit }, userInfo) {
    const { username, password, captcha } = userInfo; //解构(这里就是将登录表单中的帐号,密码和验证码)
    return new Promise((resolve, reject) => {
      login({ username: username.trim(), password: password, captcha: captcha }) //(api/uer.js)  传数据到后台server
        .then(response => {
          const { data } = response; //要有data
          commit("SET_TOKEN", data.token);
          setToken(data.token);
          resolve();
        })
        .catch(error => {
          reject(error);
        });
    });
  },
```

4. 后端接受数据,对数据进行验证,返回请求
   > 控制器
   > `/home/yhfandmxq/studyNotes/2020-10/10-28/blog/app/Http/Controllers/ExampleController.php`
   > 路由
   > `/home/yhfandmxq/studyNotes/2020-10/10-28/blog/routes/web.php`

#### class 'Redis' not found 解决方法

> /home/yhfandmxq/studyNotes/2020-10/10-28/blog/vendor/laravel/lumen-framework/config/database.php

```
安装“照亮/还原”软件包： composer require illuminate/redis:"^7.0"
在我的CentOS7上安装“ php-redis”： yum --enablerepo=epel -y install php-pecl-redis
安装“ predis”软件包： composer require predis/predis:"^1.0"
改变Redis的客户端“predis”（默认情况下它的“phpredis”） 'client' => 'predis'。所以配置是：
'redis' => [
        'cluster' => false,
        'client' => 'predis',  //这里
        'default' => [
            'host'     => env('REDIS_HOST', '127.0.0.1'),
            'port'     => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DATABASE', 0),
        ],
    ]
```

#### 验证码前后台交互

1. 前端
   > 给相应 url 传 api 请求
   > `vue-admin-template/src/api/user.js`

```
export function captcha() {
  return request({
    url: "/code/captcha/{tmp}",
    method: "get"
  });
}
```

> 页面设置点击事件,拼接生成新的 url
> `vue-admin-template/src/views/login/index.vue`

```
//验证码
    re_captcha() {
      let url = "http://xqmxqy.com/code/captcha";
      url = url + "/" + Math.random();
      document.getElementById("127ddf0de5a04167a9e427d883690ff6").src = url;
    }
```

2. 后端
   > 在 lumen 的写一个生成验证码的控制器(`https://www.blog8090.com/server-laravel-gregwar-captcha/`)
   > `/home/yhfandmxq/studyNotes/2020-10/10-28/blog/app/Http/Controllers/ExampleController.php`
   > 在 web.php 写对应的后端路由
   > `/home/yhfandmxq/studyNotes/2020-10/10-28/blog/routes/web.php`
   ```
   $router->get('/code/captcha/{tmp}', 'ExampleController@captcha');
   ```

#### 前端页面使用请求的值

> vue-admin-template/src/views/table/index.vue

```
<template>
  <td>{{ id }}</td>  //使用后端传过来的值
</template>
<script>
import { mapGetters } from "vuex";  //引入mapGetters(在vue-admin-template/src/store/getters.js里定义)

export default {
  name: "Table",
  computed: {
    ...mapGetters(["id", "name", "captcha"])  //引入
  }
};
</script>


```

> vue-admin-template/src/store/getters.js

```
const getters = {
  id: state => state.user.id,
};
export default getters;
```

> vue-admin-template/src/store/modules/user.js

```
//将元素值传到getters.js
const mutations = {
  RESET_STATE: state => {
    Object.assign(state, getDefaultState());
  },
  SET_ID: (state, id) => {
    state.id = id;
  }
};
const actions = {
  getInfo({ commit, state }) {
    return new Promise((resolve, reject) => {
      getInfo(state.token)
        .then(response => {
          const { data } = response;

          if (!data) {
            return reject("Verification failed, please Login again.");
          }

          const { username,id} = data;

          commit("SET_ID", id);   //对应mutations的定义
          resolve(data);
        })
        .catch(error => {
          reject(error);
        });
    });
  },

};
```

#### vue-element-admin 登录权限导致路由

1. 一文足矣`https://www.jianshu.com/p/ffe2790578fe`

2. 路由的书写
   > `src/router/index.js 路由配置里有公共的路由constantRoutes和异步路由asyncRoutes`路由正常格式写就好
   > 页面路由跳转`@click="$router.push('/register')"`即可
3. 路由守卫实现
   > 在 main.js 中加载全局路由守卫

```
import './permission' // 路由守卫 权限控制
```

> 在 permission 定义全局路由守卫

```
NProgress.configure({ showSpinner: false }) // 禁止右侧加载时转圈的动画

const whiteList = ['/login', '/register'] // 白名单

router.beforeEach(async (to, from, next) => {
  // 启动进度条
  NProgress.start()

  document.title = getPageTitle(to.meta.title)

  // 从 Cookie 获取 Token
  const hasToken = getToken()

  if (hasToken) {
    if (to.path === '/login') {
      // 如果当前路径为 login 则直接重定向至首页即/dashboard
      next({ path: '/' }) // 再次触发 beforeEach，to.path===/dashboard，执行下面的else
      NProgress.done()
    } else {
      // 判断用户的角色是否存在
      const hasRoles = store.getters.roles && store.getters.roles.length > 0
      if (hasRoles) { // 如果用户角色存在，则直接访问
        next()
      } else { // 第一次登陆，角色是不存在的，必须执行下面获取角色
        try {
          // 异步获取用户的角色
          // 角色是一个对象中的数组，如:
          // 'xxtoken': { roles: ['admin','editor']}
          // 所以通过 { roles } 获取角色
          const { roles } = await store.dispatch('user/getInfo')

          // 根据用户角色，动态生成路由
          const accessRoutes = await store.dispatch('permission/generateRoutes', roles)

          // 调用 router.addRoutes 动态添加路由，把不符合条件的路由清除，最后和原来的路由合并形成新的路由表
          router.addRoutes(accessRoutes)

          // 使用 replace 访问路由，不会在 history 中留下记录，
          // 这样回退不会回到 login 页面
          next({ ...to, replace: true })
        } catch (error) {
          // 错误处理
          // 清除 Token 数据，回到登录页重新登录
          await store.dispatch('user/resetToken')
          Message.error(error || '出错啦')
          next(`/login?redirect=${to.path}`)
          NProgress.done()
        }
      }
    }
  } else {
    // 没有token的情况
    if (whiteList.indexOf(to.path) !== -1) { // 如果访问的 URL 在白名单中，则直接访问
      next()
    } else {
      // 如果访问的 URL 不在白名单中，则直接重定向到登录页面，并将访问的 URL 添加到 redirect 参数中
      next(`/login?redirect=${to.path}`)
      NProgress.done()
    }
  }
})

router.afterEach(() => {
  // 设置进度条动画完成
  NProgress.done()
})

```

4. 后台路由常见的常见如下：

- 已获取 Token：
  - 访问 /login：重定向到 /
  - 访问 /login?redirect=/xxx：重定向到 /xxx
  - 访问/login 以外的路由：直接访问 /xxx
- 未获取 Token：
  - 访问 /login：直接访问 /login
  - 访问 /login 以外的路由：如访问 /dashboard，实际访问路径为/login?redirect=%2Fdashboard，登录后会直接重定向 /dashboard

### 页面直接拿接口传数据

1. 后端(写一个相应的控制器,并且写好路由)
   > `/home/yhfandmxq/studyNotes/2020-10/10-28/blog/app/Http/Controllers/ExampleController.php`

```
public function register(Request $request)
    {
        $input = $request->all();
        $name = app('db')->table('users')->where(['login_name'=>$input['username']])->get();
        $json_name = json_encode($name, JSON_FORCE_OBJECT);
        if($input['username']!='' && $input['password_one'] != '')
	    {
            if($json_name == '{}'){
                app('db')->table('users')->insert([
                    'login_name'=> $input['username'],
                    'password'=> $input['password_one'],
                    'avatar'=> 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1605266410520&di=8a403a29aafc77939c3a695e553c16d8&imgtype=0&src=http%3A%2F%2Fb-ssl.duitang.com%2Fuploads%2Fitem%2F201504%2F13%2F20150413H1123_rcVak.thumb.400_0.png',
                    'status'=> 1,
                    'guid'=> 0,
                    ]);
                $data = app('db')->table('users')->where(['login_name'=>$input['username']])->get();
                return [
                    'code' => 200,
                    'data' =>$data
                ];
            }else{
                return [
                    'code' => 502,
                ];
            }

	    }
    }
```

> `/home/yhfandmxq/studyNotes/2020-10/10-28/blog/routes/web.php`

```
$router->post('/register','ExampleController@register');
```

2. 前端
1. 写好相应的请求,对应后端的(`vue-admin-template/src/api/user.js`)

```
export function register(data) {
  return request({
    url: "/register",
    method: "post",
    data
  });
}
```

2.  vueX 的定义和使用(`vue-admin-template/src/store/modules/user.js`)

```
// user register
  register({ commit }, userInfo) {
    const { username, password_one } = userInfo; //解构
    return new Promise((resolve, reject) => {
      register({
        username: username.trim(),
        password_one: password_one
      }) //api/uer.js  传数据到后台server
        .then(response => {
          const { data } = response; //要有data
          console.log(response.data);
          commit("SET_TOKEN", data.token);
          setToken(data.token);
          resolve();
        })
        .catch(error => {
          reject(error);
        });
    });
  },
```

3. 页面的引用(`vue-admin-template/src/views/register/index.vue`)

```
toLogin() {
    this.$router.push({ path: "/login" });
  },
  toRegister() {
    register({  //这里的格式要同vuex的一样
      username: this.loginForm.username,
      password_one: this.loginForm.password_one
    }).then(response => {
      this.toLogin();
    });
  },
```
