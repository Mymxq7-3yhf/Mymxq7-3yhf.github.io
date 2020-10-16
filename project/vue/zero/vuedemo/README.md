# vuedemo

> A Vue.js project

## Build Setup

```
bash
# install dependencies
npm install

# serve with hot reload at localhost:8080
npm run dev

# build for production with minification
npm run build

# build for production and view the bundle analyzer report
npm run build --report

# run unit tests
npm run unit

# run e2e tests
npm run e2e

# run all tests
npm test
```

For a detailed explanation on how things work, check out the [guide](http://vuejs-templates.github.io/webpack/) and [docs for vue-loader](http://vuejs.github.io/vue-loader).

### 使用 vue-cli 脚手架实现 demo 文件夹下 html 页面的效果

#### 关于 vue.js 和 vue-cli 脚手架的安装

```
PS：如果安装报错，最前面加sudo便可
```

- 安装 vue

```
查看npm和node版本
node -v
npm -v
```

1. 查看 vue 版本

```
 vue --version
```

2. 安装

```
（全局）
 npm install vue -g
 （局部）
 npm install vue --save-dev
```

- 安装 vue-cli 脚手架

1. 将 npm 源更换成淘宝源

```
npm config set registry https://registry.npm.taobao.org 
```

- 验证是否成功

```
  npm config get registry
```

2. 全局安装 vue-cli

```
npm install vue-cli -g

```

3. 在项目目录创建项目

```
vue init webpack

```

4. 进入项目目录执行项目

```
npm run dev
```

> 目录结构及其对应作用

```
├── build/                      # webpack 编译任务配置文件: 开发环境与生产环境
│   └── ...
├── config/
│   ├── index.js                # 项目核心配置
│   └── ...
├ ── node_module/               #项目中安装的依赖模块
   ── src/
│   ├── main.js                 # 程序入口文件
│   ├── App.vue                 # 程序入口vue组件
│   ├── components/             # 组件
│   │   └── ...
│   └── assets/                 # 资源文件夹，一般放一些静态资源文件
│       └── ...
├── static/                     # 纯静态资源 (直接拷贝到dist/static/里面)
├── test/
│   └── unit/                   # 单元测试
│   │   ├── specs/              # 测试规范
│   │   ├── index.js            # 测试入口文件
│   │   └── karma.conf.js       # 测试运行配置文件
│   └── e2e/                    # 端到端测试
│   │   ├── specs/              # 测试规范
│   │   ├── custom-assertions/  # 端到端测试自定义断言
│   │   ├── runner.js           # 运行测试的脚本
│   │   └── nightwatch.conf.js  # 运行测试的配置文件
├── .babelrc                    # babel 配置文件
├── .editorconfig               # 编辑配置文件
├── .gitignore                  # 用来过滤一些版本控制的文件，比如node_modules文件夹
├── index.html                  # index.html 入口模板文件
└── package.json                # 项目文件，记载着一些命令和依赖还有简要的项目描述信息
└── README.md                   #介绍自己这个项目的，可参照github上star多的项目。
build/
```

> 参考网址:`https://www.jianshu.com/p/1ee1c410dc67`

#### Aliyun 安装 NPM 总是 3.5.2 解决方案

在这里我遇到了一个大问题，npm 安装速度龟速，七柱香的时间还在下，原因是：由于默认的命令 阿里云安装的 Node 是 8.x 版本，导致 NPM 一直安装的都是 3.5.2 版本，死活升级不上去，最后手动安装指定版本解决。

1. 指定版本安装

```
wget -qO- https://deb.nodesource.com/setup_10.x | sudo -E bash -
sudo apt-get install -y nodejs
```

2. 安装 npm

```
apt-get install nodejs
```

3. 查看 npm

```
npm -v
```

> 参考网址：`http://www.mamicode.com/info-detail-2729849.html`

#### 布局

- 总布局

```
<template>
    <div>
    </div>
</template>
<script>

</script>
<style>

</style>
```

> <template></tamplate>标签

- template 标签里面有且必须有一个大的 div

```
Eg.
<template>
    <div>
            <div></div>
    </div>
</template>
错误写法：
<template>
    <div></div>
    <div></div>
</template>
```

> 参考网址：`https://blog.csdn.net/u013594477/article/details/80774483`

#### 代码编写

1. 主页面

- <table> 标签定义 HTML 表格,简单的 HTML 表格由 table 元素以及一个或多个 tr、th 或 td 元素组成。
  `tr 元素定义表格行，th 元素定义表头，td 元素定义表格单元。 `

```
 <table border="1" class="tbTotal" style="border-collapse:collapse;">
//定义第一行，表头
 <tr class="trone">
        <th>编号</th>
        <th>合同编号</th>
        <th>公司名称</th>
        <th>联系人</th>
        <th>联系电话</th>
        <th>合同类型</th>
        <th>合同状态</th>
        <th>负责业务员</th>
        <th>设备数量</th>
        <th id="thten">操作</th>
</tr>
//定义表格单元（v-for循环遍历读入）
 <tr v-for="(list, index) in lists" :key="list.index">
        <td>{{ index + 1 }}</td>
        <td>
          <button v-on:click="data(index)" id="contractnocolor">
            {{ list.ContractNo }}
          </button>
        </td>
        <td>{{ list.name }}</td>
        <td>{{ list.contacts }}</td>
        <td>{{ list.phone }}</td>
        <td v-if="list.type == '标准'">
          <div id="biaozhun">{{ list.type }}</div>
        </td>
        <td v-if="list.type == '特殊'">
          <div id="teshu">{{ list.type }}</div>
        </td>
        <td>{{ list.state }}</td>
        <td>{{ list.salesman }}</td>
        <td>{{ list.number }}</td>
        <td>
          <button
            id="bianji"
            v-on:click="showbtngai"
            @click="updata(list, index)"
          >
            编辑
          </button>
        //修改数据表单
          <div v-show="showgai">
            <div class="all">
              <div id="top">
                <h3 id="h3one">修改数据</h3>
                <button id="h3two" v-on:click="showbtngai">X</button>
              </div>
              <div id="divone">
                客户公司名称
                <input id="inputone" v-model="forms.name" />
              </div>
              <div id="divtwo">
                联系人名字<input id="inputone" v-model="forms.contacts" />
              </div>
              <div id="divthree">
                联系人手机号<input id="inputone" v-model="forms.phone" />
              </div>
              <div id="divfour">
                合同类型
                <select id="option" v-model="forms.type">
                  <option>请选择</option>
                  <option>标准</option>
                  <option>特殊</option>
                </select>
              </div>
              <div id="divseven">
                合同状态
                <select id="option" v-model="forms.state">
                  <option>请选择</option>
                  <option>已生效</option>
                  <option>未生效</option>
                </select>
              </div>
              <div id="diveight">
                业务员<input id="inputone" v-model="forms.salesman" />
              </div>
              <div id="divnine">
                设备数量<input id="inputone" v-model="forms.number" />
              </div>
              <div id="divten">
                <button id="quxiao" v-on:click="showbtngai">
                  <div v-show="showgai">取消</div>
                </button>
                <button
                  id="queding"
                  v-on:click="showbtngai"
                  @click="change(forms.id)"
                >
                  保存
                </button>
              </div>
            </div>
          </div>
          <button id="shanchu" @click="deletes(index)">
            删除
          </button>
        </td>
      </tr>
 </table>
```

2. 新建数据

```
<button v-on:click="showbtnadd" class="newdata">新建数据</button>

    <div v-show="showadd">
      <div class="all">
        <div id="top">
          <h3 id="h3one">新建数据</h3>
          <button id="h3two" v-on:click="showbtnadd">
            <div v-show="showadd">X</div>
          </button>
        </div>
        <div id="divone">
          <span style="color:red">*</span>客户公司名称
          <input id="inputone" v-model="form.name" />
        </div>
        <div id="divtwo">
          <span style="color:red">*</span>联系人名字<input
            id="inputone"
            v-model="form.contacts"
          />
        </div>
        <div id="divthree">
          <span style="color:red">*</span>联系人手机号<input
            id="inputone"
            v-model="form.phone"
          />
        </div>
        <div id="divfour">
          <span style="color:red">*</span>合同类型
          <select id="option" v-model="form.type">
            <option>请选择</option>
            <option>标准</option>
            <option>特殊</option>
          </select>
        </div>
        <div id="divfive">
          <span style="color:red">*</span>公司详细地址<input id="inputone" />
        </div>
        <div id="divsix">备注<input id="inputtwo" /></div>
        <div id="divseven">
          <span style="color:red">*</span>合同状态
          <select id="option" v-model="form.state">
            <option>请选择</option>
            <option>已生效</option>
            <option>未生效</option>
          </select>
        </div>
        <div id="diveight">
          <span style="color:red">*</span>业务员<input
            id="inputone"
            v-model="form.salesman"
          />
        </div>
        <div id="divnine">
          <span style="color:red">*</span>设备数量<input
            id="inputone"
            v-model="form.number"
          />
        </div>
        <div id="divten">
          <button id="quxiao" v-on:click="showbtnadd">
            <div v-show="showadd">取消</div>
          </button>
          <button id="queding" v-on:click="showbtnadd" @click="add">
            <div v-show="showadd">保存</div>
          </button>
        </div>
      </div>
    </div>
```

3. <script>标签的使用

```
<script>
//引入json文件
import dataJason from '../public/data.json'
//引入自定义组件（尚未使用）
import children from './Add.vue'
export default {
  name: 'HelloWorld',
  data() {
    return {
      flag: true,
      add1: false,
      id: '',
      ok: [true, true, true, true, true, true, true, true, true, true, true],
      showadd: false,
      showgai: false,
      lists: [],
      form: {
        ContractNo: '',
        name: '',
        contacts: '',
        phone: '',
        type: '',
        state: '',
        salesman: '',
        number: 2,
        bianji: '',
        shanchu: ''
      },
      forms: {
        id: '',
        ContractNo: '',
        name: '',
        contacts: '',
        phone: '',
        type: '',
        state: '',
        salesman: '',
        number: 2
      }
    }
  },
  compents: {
    children: children
  },
  created() {
    // 1.json文件中的对象赋给数组
    // 2.不用赋值，直接在vue中使用，例如:v-for="item in dataJson"
    this.lists = dataJason.compent
  },

  methods: {
    data(index) {
      if (index === 0) {
        let routeData = this.$router.resolve({
          name: 'Message',
          params: { id: '2' }
        })
        window.open(routeData.href, '_blank')
      }
    },
    newdata() {
      // this.$router.push({ name: 'Add', params: { id: '2' } })
    },
    showbtnadd() {
      this.showadd = !this.showadd
    },
    showbtngai() {
      this.showgai = !this.showgai
    },
    deletes(index) {
      this.lists.splice(index, 1)
    },
    add() {
      let obj = {
        ContractNo: 'YQ - 20170718982737',
        name: this.form.name,
        contacts: this.form.contacts,
        phone: this.form.phone,
        type: this.form.type,
        state: this.form.state,
        salesman: this.form.salesman,
        number: this.form.number
      }
      let {
        ContractNo, // eslint-disable-line no-unused-vars
        name, // eslint-disable-line no-unused-vars
        contacts, // eslint-disable-line no-unused-vars
        phone, // eslint-disable-line no-unused-vars
        type, // eslint-disable-line no-unused-vars
        state, // eslint-disable-line no-unused-vars
        salesman, // eslint-disable-line no-unused-vars
        number // eslint-disable-line no-unused-vars
      } = obj
      this.lists.push(obj)
    },
    updata(list, index) {
      this.forms.id = index
      this.forms.name = list.name
      this.forms.contacts = list.contacts
      this.forms.phone = list.phone
      this.forms.type = list.type
      this.forms.state = list.state
      this.forms.salesman = list.salesman
      this.forms.number = list.number
    },
    change(index) {
      console.log(index)
      this.lists[index].name = this.forms.name
      this.lists[index].contacts = this.forms.contacts
      this.lists[index].phone = this.forms.phone
      this.lists[index].type = this.forms.type
      this.lists[index].state = this.forms.state
      this.lists[index].salesman = this.forms.salesman
    }
  }
}
</script>
```

#### 遇到的坑

1. 每一个元素都是一个方框，使用`tyle="border-collapse:collapse;"`将方框合并成一个

2. v-for 遍历数组 `v-for="(list, index) in lists" :key="list.index"`

   > :key 用 index 做 key（十分不建议这么做）

   > 参考网址：`https://www.zhihu.com/question/61064119`

3. lists 和 json 文件定义引用

   > 由于我的.json 文件是对象数组，所以引用的时候要将数组名一并写

   `Eg. this.lists = dataJason.compent`

```
import dataJason from '../public/data.json'
export default {
  name: 'HelloWorld',
  data() {
    return {
      lists: []
    }
  },
  created() {
    // 1.json文件中的对象赋给数组
    // 2.不用赋值，直接在vue中使用，例如:v-for="item in dataJson"
    this.lists = dataJason.compent
  },
  }
}
```

4. 新建数据(可以写成一个组件，然后调用`import children from './Add.vue'`)
   > 使用 v-show 来进行同页面的显示/隐藏

```
写在div下
<button v-on:click="showbtnadd" class="newdata">新建数据</button>

    <div v-show="showadd">
      <div class="all">
        <div id="top">
          <h3 id="h3one">新建数据</h3>
          <button id="h3two" v-on:click="showbtnadd">
            <div v-show="showadd">X</div>
          </button>
        </div>
        <div id="divone">
          <span style="color:red">*</span>客户公司名称
          <input id="inputone" v-model="form.name" />
        </div>
        <div id="divtwo">
          <span style="color:red">*</span>联系人名字<input
            id="inputone"
            v-model="form.contacts"
          />
        </div>
        <div id="divthree">
          <span style="color:red">*</span>联系人手机号<input
            id="inputone"
            v-model="form.phone"
          />
        </div>
        <div id="divfour">
          <span style="color:red">*</span>合同类型
          <select id="option" v-model="form.type">
            <option>请选择</option>
            <option>标准</option>
            <option>特殊</option>
          </select>
        </div>
        <div id="divfive">
          <span style="color:red">*</span>公司详细地址<input id="inputone" />
        </div>
        <div id="divsix">备注<input id="inputtwo" /></div>
        <div id="divseven">
          <span style="color:red">*</span>合同状态
          <select id="option" v-model="form.state">
            <option>请选择</option>
            <option>已生效</option>
            <option>未生效</option>
          </select>
        </div>
        <div id="diveight">
          <span style="color:red">*</span>业务员<input
            id="inputone"
            v-model="form.salesman"
          />
        </div>
        <div id="divnine">
          <span style="color:red">*</span>设备数量<input
            id="inputone"
            v-model="form.number"
          />
        </div>
        <div id="divten">
          <button id="quxiao" v-on:click="showbtnadd">
            <div v-show="showadd">取消</div>
          </button>
          <button id="queding" v-on:click="showbtnadd" @click="add">
            <div v-show="showadd">保存</div>
          </button>
        </div>
      </div>
    </div>
写在script下
export default {
  name: 'HelloWorld',
  data() {
    return {
      showadd: false,
      lists: [],
      form: {
        ContractNo: '',
        name: '',
        contacts: '',
        phone: '',
        type: '',
        state: '',
        salesman: '',
        number: 2,
        bianji: '',
        shanchu: ''
      },
    }
  },
  compents: {
    children: children
  },

  methods: {
      //在新页面打开
    data(index) {
      if (index === 0) {
        let routeData = this.$router.resolve({
          name: 'Message',
          params: { id: '2' }
        })
        window.open(routeData.href, '_blank')
      }
    },
    showbtnadd() {
      this.showadd = !this.showadd
    },
    add() {
      let obj = {
        ContractNo: 'YQ - 20170718982737',
        name: this.form.name,
        contacts: this.form.contacts,
        phone: this.form.phone,
        type: this.form.type,
        state: this.form.state,
        salesman: this.form.salesman,
        number: this.form.number
      }
      let {
        ContractNo, // eslint-disable-line no-unused-vars
        name, // eslint-disable-line no-unused-vars
        contacts, // eslint-disable-line no-unused-vars
        phone, // eslint-disable-line no-unused-vars
        type, // eslint-disable-line no-unused-vars
        state, // eslint-disable-line no-unused-vars
        salesman, // eslint-disable-line no-unused-vars
        number // eslint-disable-line no-unused-vars
      } = obj
      this.lists.push(obj)
    }
  }
}
```

5. 修改数据
   > 创建一个新数组

```
data() {
    return {
      showgai: false,
      forms: {
        id: '',
        ContractNo: '',
        name: '',
        contacts: '',
        phone: '',
        type: '',
        state: '',
        salesman: '',
        number: 2
      }
    }
  },
```

> 创建一个函数 updata，将 v-for 遍历的数据写入(PS:这里要将下标也赋值过去)

```
updata(list, index) {
      this.forms.id = index
      this.forms.name = list.name
      this.forms.contacts = list.contacts
      this.forms.phone = list.phone
      this.forms.type = list.type
      this.forms.state = list.state
      this.forms.salesman = list.salesman
      this.forms.number = list.number
    },

```

> 点击保存的时候，定义并调用 change 函数，将 updata 里面的值覆盖到原数组对象 list `@click="change(forms.id)`

```
 change(index) {
      console.log(index)
      this.lists[index].name = this.forms.name
      this.lists[index].contacts = this.forms.contacts
      this.lists[index].phone = this.forms.phone
      this.lists[index].type = this.forms.type
      this.lists[index].state = this.forms.state
      this.lists[index].salesman = this.forms.salesman
    }
```

```
        <button
            id="bianji"
            v-on:click="showbtngai"
            @click="updata(list, index)"
          >
            编辑
          </button>

          <div v-show="showgai">
            <div class="all">
              <div id="top">
                <h3 id="h3one">修改数据</h3>
                <button id="h3two" v-on:click="showbtngai">X</button>
              </div>
              <div id="divone">
                客户公司名称
                <input id="inputone" v-model="forms.name" />
              </div>
              <div id="divtwo">
                联系人名字<input id="inputone" v-model="forms.contacts" />
              </div>
              <div id="divthree">
                联系人手机号<input id="inputone" v-model="forms.phone" />
              </div>
              <div id="divfour">
                合同类型
                <select id="option" v-model="forms.type">
                  <option>请选择</option>
                  <option>标准</option>
                  <option>特殊</option>
                </select>
              </div>
              <div id="divseven">
                合同状态
                <select id="option" v-model="forms.state">
                  <option>请选择</option>
                  <option>已生效</option>
                  <option>未生效</option>
                </select>
              </div>
              <div id="diveight">
                业务员<input id="inputone" v-model="forms.salesman" />
              </div>
              <div id="divnine">
                设备数量<input id="inputone" v-model="forms.number" />
              </div>
              <div id="divten">
                <button id="quxiao" v-on:click="showbtngai">
                  <div v-show="showgai">取消</div>
                </button>
                <button
                  id="queding"
                  v-on:click="showbtngai"
                  @click="change(forms.id)"
                >
                  保存
                </button>
              </div>
            </div>
          </div>
```
