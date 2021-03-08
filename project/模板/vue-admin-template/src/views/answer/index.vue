<template>
  <div style="padding:20px;" id="app">
    <el-button type="text" @click="getQuestion">新增答案</el-button>

    <el-dialog title="新增答案" :visible.sync="dialogAdd">
      <el-form ref="form" :model="form" @submit.native.prevent="submit">
        <el-form-item
          label="题目"
          :label-width="formLabelWidth"
          style="margin-right:200px;"
        >
          <el-select
            v-model="getquestionList.content"
            @change="changeLocationValue"
            placeholder="请选择"
          >
            <el-option
              v-for="item in getquestionList"
              :key="item.guid"
              :label="item.content"
              :value="item.content"
            ></el-option>
          </el-select>
          <el-input
            v-model="selectinput"
            :disabled="true"
            style="width:100px;margin-left:50px"
          >
          </el-input>
        </el-form-item>
        <!-- 固定项目 -->
        <div v-if="questionSingle">
          <el-form-item label="答案" :label-width="formLabelWidth">
            <el-input
              autocomplete="off"
              v-model="form.content"
              style="width:300px;"
            ></el-input>

            <el-radio v-model="form.radio" label="1" style="margin-left:50px;"
              >正确</el-radio
            >
            <el-radio v-model="form.radio" label="2">错误</el-radio>
          </el-form-item>
        </div>

        <!-- 动态增加项目 -->
        <!-- 不止一个项目，用div包裹起来 -->
        <div
          v-if="questionSingleSign"
          v-for="(item, index) in form.excessItem"
          :key="index"
        >
          <el-form-item label="答案" :label-width="formLabelWidth">
            <el-input
              autocomplete="off"
              v-model="item.content"
              style="width:300px;"
            ></el-input>

            <el-radio v-model="item.radio" label="1" style="margin-left:50px;"
              >正确</el-radio
            >
            <el-radio v-model="item.radio" label="2">错误</el-radio>
            <el-button
              type="danger"
              icon="el-icon-delete"
              circle
              @click="deleteItem(item, index)"
            ></el-button>
          </el-form-item>
        </div>

        <div v-if="questionJjudge">
          <el-form-item
            label="答案"
            :label-width="formLabelWidth"
            style="margin-right:50px;"
          >
            <el-radio v-model="radio" label="1" style="margin-left:50px;"
              >正确</el-radio
            >
            <el-radio v-model="radio" label="2">错误</el-radio>
          </el-form-item>
        </div>
      </el-form>

      <div slot="footer" class="dialog-footer">
        <el-button
          type="text"
          @click="addItem"
          :plain="true"
          style="margin:0px;border:0px"
          >新增答案</el-button
        >
        <el-button @click="dialogAdd = false">取 消</el-button>
        <el-button type="primary" @click="addData">确 定</el-button>
      </div>
    </el-dialog>

    <el-table
      :data="getanswerList"
      style="width: 100%;margin-bottom: 20px;"
      row-key="id"
      border
      default-expand-all
    >
      <el-table-column prop="id" label="ID" width="50" sortable>
      </el-table-column>
      <el-table-column prop="question_guid" label="题目" width="550">
      </el-table-column>
      <el-table-column prop="content" label="答案内容" width="550">
      </el-table-column>
      <el-table-column prop="isright" label="是否正确" width="100">
      </el-table-column>
      <el-table-column prop="status" label="状态" width="100">
      </el-table-column>

      <el-table-column label="操作">
        <template slot-scope="scope">
          <el-button size="mini" @click="handleEdit(scope.$index, scope.row)"
            >编辑</el-button
          >
          <el-button
            size="mini"
            type="danger"
            @click="handleDelete(scope.$index, scope.row)"
            >删除</el-button
          >
        </template>
      </el-table-column>
    </el-table>
    <el-pagination
      @size-change="handleSizeChange"
      @current-change="handleCurrentChange"
      :current-page="currentPage"
      :page-sizes="[1, 5, 10, 20]"
      :page-size="pagesize"
      layout="total, sizes, prev, pager, next, jumper"
      :total="count"
    >
    </el-pagination>

    <el-dialog title="编辑" :visible.sync="dialogFormVisible">
      <el-form>
        <el-form-item label="题目" :label-width="formLabelWidth">
          <el-select v-model="nowListData.question_guid" placeholder="请选择">
            <el-option
              v-for="item in getquestionAllList"
              :key="item.content"
              :label="item.content"
              :value="item.content"
            >
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="内容" :label-width="formLabelWidth">
          <el-input autocomplete="off" v-model="nowListData.content"></el-input>
        </el-form-item>
        <el-form-item label="是否正确" :label-width="formLabelWidth">
          <template>
            <el-select v-model="nowListData.isright" placeholder="请选择">
              <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              >
              </el-option>
            </el-select>
          </template>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="nochangeedit">取 消</el-button>
        <el-button type="primary" @click="editData">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>
<script>
import {
  getData,
  deleteData,
  editData,
  addData,
  getQuestion,
  getQuestionType,
  changeData
} from "@/api/answer";

export default {
  name: "Answer",
  data() {
    return {
      form: {
        content: "",
        radio: "1",
        excessItem: []
      },
      //拿到数据
      getanswerList: [],
      //拿到题目所有数据
      getquestionAllList: [],
      //拿到题目数据(增加)
      getquestionList: [],
      //拿到对应guid题目数据
      getquestionTypeList: [],
      //拿到题目数据总数
      allcount: 1,
      //拿到答案数据总数
      count: 1,
      pagesize: 10,
      currpage: 1,
      currentPage: 1,
      nowListData: [],
      //表单数据
      content: "",
      radio: "1",

      dialogFormVisible: false,
      dialogAdd: false,
      formLabelWidth: "120px",

      //输入框判断题目类型
      selectinput: "",

      //判断题目类型
      questionJjudge: false,

      //选中题目类型
      getquestionType: "",
      //题目guid
      getquestionGuid: "",
      //题目内容
      getquestionContent: "",

      getchangeList: [],

      options: [
        {
          value: "正确",
          label: "正确"
        },
        {
          value: "错误",
          label: "错误"
        }
      ],
      questionSingleSign: false
    };
  },
  created() {
    this.getData();
  },
  methods: {
    //1.重点是这个方法 submit () {} - form @submit.prevent="submit" -重点是这个方法 submit () {},
    //2.可以在这里向服务器发送数据
    submit() {
      if (!this.getquestionList.content) {
        showToast("请选择题目!");
        return false;
      }

      if (!this.form.content) {
        showToast("答案不能为空,请输入答案!");
        return false;
      }

      if (!this.form.radio) {
        showToast("请告诉哥哥我,答案是否正确!");
        return false;
      }

      if (!this.form.excessItem.content) {
        showToast("答案不能为空,请输入答案!");
        return false;
      }

      if (!this.form.excessItem.radio) {
        showToast("请告诉哥哥我,答案是否正确!");
        return false;
      }
      return true;
    },
    //新增数据加一条
    addItem() {
      //判断是否为单选题
      if (this.questionSingleSign == true) {
        this.form.excessItem.push({
          content: "",
          radio: ""
        });
      } else {
        this.$message("抱歉,未选题目或者为判断题不能添加答案");
      }
    },
    deleteItem(item, index) {
      this.form.excessItem.splice(index, 1);
    },
    //新增题目,写入后端数据库
    addData() {
      //传给后台的数据
      addData(this.getquestionGuid, this.form).then(response => {
        //返回的数据
        this.dialogAdd = false;
        this.getData(); //调用查函数,拿数据
      });
    },

    //删除(将status变为0)
    handleDelete(index, row) {
      //直接通过api接口像后端发送请求
      console.log(row);
      deleteData(row.id).then(response => {
        this.getData();
      });
    },

    //改
    handleEdit(index, row) {
      this.dialogFormVisible = true;
      this.nowListData = row;
      // console.log(this.nowListData);
    },
    nochangeedit() {
      this.getData();
      this.dialogFormVisible = false;
    },
    //编辑数据,并前后端修改
    editData() {
      editData(this.nowListData).then(response => {});
      this.dialogFormVisible = false;
    },

    //数据显示
    getData() {
      //直接通过api接口像后端发送请求
      getData(this.currentPage, this.pagesize).then(response => {
        this.getanswerList = response.data;
        this.count = response.count;
        // console.log(this.getanswerList);

        //遍历后台所拿到的数据,将其进行判断,显示
        this.changeData();
      });
    },
    //拿题目数据
    getQuestion() {
      getQuestion().then(response => {
        this.getquestionList = response.data;
        this.allcount = response.count;
        this.dialogAdd = true;
        console.log(this.getquestionList);
      });
    },
    //拿选择器数据
    changeLocationValue(val) {
      //getquestionList是v-for里面的也是datas里面的值
      let obj = {};

      obj = this.getquestionList.find(item => {
        return item.content === val;
      });
      // console.log(obj); //拿到选中的数据对象
      this.questionguid = obj.guid; //拿到数据中的guid
      // console.log(this.questionguid);

      this.getQuestionType();
      // console.log(this.getQuestionType());
    },
    //拿对应guid数据
    getQuestionType() {
      getQuestionType(this.questionguid).then(response => {
        this.getquestionTypeList = response.data;
        console.log(this.getquestionTypeList[0].guid);
        this.getquestionGuid = this.getquestionTypeList[0].guid;
        this.getquestionContent = this.getquestionTypeList[0].content;

        this.getquestionType = this.getquestionTypeList[0].type;
        if (this.getquestionType == 1) {
          this.selectinput = "单选题";
          this.questionSingle = true;
          this.questionSingleSign = true;
          this.questionJjudge = false;
        }
        if (this.getquestionType == 2) {
          this.selectinput = "判断题";
          this.questionJjudge = true;
          this.questionSingleSign = false;
          this.questionSingle = false;
        }
      });
    },
    handleSizeChange(val) {
      this.pagesize = val;
      getData(this.currpage, val).then(response => {
        this.getanswerList = response.data;
        // console.log(this.getanswerList);

        //遍历后台所拿到的数据,将其进行判断,显示
        this.changeData();
      });
      console.log(`每页 ${val} 条`);
    },
    handleCurrentChange(val) {
      getData(val, this.pagesize).then(response => {
        this.getanswerList = response.data;
        // console.log(this.getanswerList);

        //遍历后台所拿到的数据,将其进行判断,显示
        this.changeData();
      });
      this.currpage = val;
      console.log(`当前页: ${val}`);
    },
    changeData() {
      changeData().then(response => {
        this.getquestionAllList = response.data;
        this.allcount = response.count;
        console.log(this.getquestionAllList);
        //对应题目的guid和答案的question_guid是否一致
        for (let i = 0; i < this.count - 1; i++) {
          for (let j = 0; j < this.allcount; j++) {
            if (
              this.getanswerList[i].question_guid ==
              this.getquestionAllList[j].guid
            ) {
              this.getanswerList[i].question_guid = this.getquestionAllList[
                j
              ].content;
            }
          }
        }
        //答案的1/2转变为正确/错误
        for (let i = 0; i < this.count - 1; i++) {
          if (this.getanswerList[i].isright == 1) {
            this.getanswerList[i].isright = "正确";
          } else {
            this.getanswerList[i].isright = "错误";
          }
        }

        //状态的1/2转变为启用/禁用
        for (let i = 0; i < this.count - 1; i++) {
          if (this.getanswerList[i].status == 1) {
            this.getanswerList[i].status = "启用";
          } else {
            this.getanswerList[i].status = "禁用";
          }
        }
        // console.log(this.getanswerList);
      });
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1,
h2 {
  font-weight: normal;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  margin: 0 10px;
}

a {
  color: #42b983;
}
tr,
th {
  text-align: center;
}
</style>
