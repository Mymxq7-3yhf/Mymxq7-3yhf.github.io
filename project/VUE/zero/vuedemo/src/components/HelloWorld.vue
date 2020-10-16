<template>
  <div>
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

    <table border="1" class="tbTotal" style="border-collapse:collapse;">
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
  </div>
</template>

<script>
import dataJason from '../public/data.json'
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

<style>
.newdata {
  position: absolute;
  left: 310px;
  top: 150px;
  width: 120px;
  height: 40px;
  background-color: #008aff;
  color: #efe9ff;
  border-radius: 5px 5px 5px 5px;
  outline: none;
}
.tbTotal {
  left: 210px;
  top: 213px;
  width: 1261px;
  margin-top: 210px;
  margin-left: 300px;
}
.trone {
  width: 1261px;
  height: 48px;
  border-collapse: collapse;
  background-color: #eef0f6;
}
tr th {
  height: 48px;
  font-style: normal;
  font-size: 16px;
  border-color: grey;
}
tr td {
  height: 44px;
}
#thten {
  width: 168px;
}
#contractnocolor {
  color: #ffa718;
  outline: none;
  background-color: white;
  border: 0px;
}
#biaozhun {
  width: 50px;
  margin-left: 20px;
  color: #008dff;
  background-color: #b3dcff;
  text-align: center;
  border-radius: 5px 5px 5px 5px;
}
#teshu {
  width: 50px;
  margin-left: 20px;
  color: #f0f0f0;
  background-color: #9c9a9c;
  text-align: center;
  border-radius: 5px 5px 5px 5px;
}
#bianji {
  color: #fff1de;
  background-color: #ff9c00;
  border-radius: 5px 5px 5px 5px;
  text-align: center;
  margin-right: 17px;
  border: 0px;
  outline: none;
}
#shanchu {
  color: #fff1de;
  background-color: #ff0100;
  text-align: center;
  border-radius: 5px 5px 5px 5px;
  border: 0px;
  outline: none;
}

.all {
  position: absolute;
  left: 500px;
  top: 50px;
  width: 692px;
  height: 801px;
  z-index: 2;
  background-color: white;
}
#top {
  width: 693px;
  height: 62px;
  background-color: #008aff;
}
#h3one {
  color: white;
  text-align: left;
  line-height: 27px;
  float: left;
  margin-left: 20px;
}
#h3two {
  color: white;
  text-align: right;
  line-height: 27px;
  float: right;
  margin-right: 20px;
  margin-top: 20px;
  background-color: #008aff;
}
#divone {
  position: absolute;
  left: 50px;
  top: 90px;
}
#inputone {
  position: absolute;
  width: 360px;
  height: 30px;
  font-size: 13px;
  margin-left: 20px;
}
#inputtwo {
  position: absolute;
  width: 360px;
  height: 63px;
  font-size: 13px;
  margin-left: 20px;
}
#divtwo {
  position: absolute;
  left: 67px;
  top: 150px;
}
#divthree {
  position: absolute;
  left: 50px;
  top: 210px;
}
#divfour {
  position: absolute;
  left: 80px;
  top: 270px;
}
#divfive {
  position: absolute;
  left: 50px;
  top: 330px;
}
#divsix {
  position: absolute;
  left: 120px;
  top: 390px;
}
#divseven {
  position: absolute;
  left: 80px;
  top: 473px;
}
#diveight {
  position: absolute;
  left: 97px;
  top: 533px;
}
#divnine {
  position: absolute;
  left: 80px;
  top: 593px;
}
#divten {
  position: absolute;
  left: 0px;
  top: 700px;
  background-color: #eeeeee;
  width: 692px;
  height: 56px;
  text-align: right;
  line-height: 56px;
}
#option {
  position: absolute;
  width: 300px;
  height: 30px;
  font-size: 13px;
  margin-left: 20px;
}
#quxiao {
  width: 140px;
  height: 40px;
  border-radius: 5px;
  background-color: #ffffff;
  color: #333333;
  line-height: 40px;
}
#queding {
  width: 140px;
  height: 40px;
  border-radius: 5px;
  background-color: #008aff;
  color: #effdff;
  line-height: 40px;
}
</style>
