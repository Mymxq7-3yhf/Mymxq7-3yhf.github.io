<template>
  <div style="padding:20px;" id="app">
    <el-button type="text" @click="dialogAdd = true">新增题目</el-button>

    <el-dialog title="新增题目" :visible.sync="dialogAdd">
      <el-form>
        <el-form-item label="题型" :label-width="formLabelWidth">
          <el-radio v-model="radio" label="1">单选题</el-radio>
          <el-radio v-model="radio" label="2">判断题</el-radio>
        </el-form-item>

        <el-form-item label="内容" :label-width="formLabelWidth">
          <el-input autocomplete="off" v-model="content"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogAdd = false">取 消</el-button>
        <el-button type="primary" @click="addData">确 定</el-button>
      </div>
    </el-dialog>

    <el-table
      :data="getquestionList"
      style="width: 100%;margin-bottom: 20px;"
      row-key="id"
      border
      default-expand-all
    >
      <el-table-column prop="id" label="ID" width="50" sortable>
      </el-table-column>
      <el-table-column prop="type" label="题型" width="100"> </el-table-column>
      <el-table-column prop="content" label="内容" width="700">
      </el-table-column>
      <el-table-column prop="status" label="状态" width="100">
      </el-table-column>
      <el-table-column prop="add_user" label="管理员guid" width="280">
      </el-table-column>
      <el-table-column prop="addtime" label="创建时间" width="180">
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
        <el-form-item label="题型" :label-width="formLabelWidth">
          <template>
            <el-select v-model="nowListData.type" placeholder="请选择">
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
        <el-form-item label="内容" :label-width="formLabelWidth">
          <el-input autocomplete="off" v-model="nowListData.content"></el-input>
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
import { getData, deleteData, editData, addData } from "@/api/question";
import { mapGetters } from "vuex";

export default {
  name: "Question",
  computed: {
    ...mapGetters(["guid"]) //直接拿
  },
  data() {
    return {
      //拿到数据
      getquestionList: [],
      //拿到数据总数
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
      //题型
      options: [
        {
          value: "单选题",
          label: "单选题"
        },
        {
          value: "判断题",
          label: "判断题"
        }
      ]
    };
  },
  created() {
    this.getData();
  },
  methods: {
    //新增题目,写入后端数据库
    addData() {
      addData(this.content, this.radio, this.guid).then(response => {
        //传给后台的数据
        console.log(this.guid); //直接拿
        this.dialogAdd = false;
        this.getData(); //调用查函数,拿数据
      });
    },

    //删除(将status变为0)
    handleDelete(index, row) {
      //直接通过api接口像后端发送请求
      deleteData(row.guid).then(response => {
        this.getData();
      });
    },

    //改
    handleEdit(index, row) {
      this.dialogFormVisible = true;
      this.nowListData = row;
      console.log(this.nowListData);
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
        this.getquestionList = response.data;
        console.log(this.getquestionList);
        this.count = response.count;

        //遍历后台所拿到的数据,将其进行判断,显示
        this.changeData();
      });
    },

    handleSizeChange(val) {
      this.pagesize = val;
      getData(this.currpage, val).then(response => {
        this.getquestionList = response.data;
        console.log(this.getquestionList);

        //遍历后台所拿到的数据,将其进行判断,显示
        this.changeData();
      });
      console.log(`每页 ${val} 条`);
    },
    handleCurrentChange(val) {
      getData(val, this.pagesize).then(response => {
        this.getquestionList = response.data;
        console.log(this.getquestionList);

        //遍历后台所拿到的数据,将其进行判断,显示
        this.changeData();
      });
      this.currpage = val;
      console.log(`当前页: ${val}`);
    },
    changeData() {
      //遍历后台所拿到的数据,将其进行判断,显示
      for (let i = 0; i < this.count; i++) {
        if (this.getquestionList[i].type == 1) {
          this.getquestionList[i].type = "单选题";
        }
        if (this.getquestionList[i].type == 2) {
          this.getquestionList[i].type = "判断题";
        }
      }
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
