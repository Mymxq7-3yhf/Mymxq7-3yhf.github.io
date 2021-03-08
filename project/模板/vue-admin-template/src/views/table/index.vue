<template>
  <div style="padding:20px;" id="app">
    <el-button type="text" @click="dialogAdd = true">新增管理员</el-button>

    <el-dialog title="新增管理员" :visible.sync="dialogAdd">
      <el-form>
        <el-form-item label="用户名" :label-width="formLabelWidth">
          <el-input autocomplete="off" v-model="form.login_name"></el-input>
        </el-form-item>
        <el-form-item label="密码" :label-width="formLabelWidth">
          <el-input autocomplete="off" v-model="form.password"></el-input>
        </el-form-item>
        <el-form-item label="昵称" :label-width="formLabelWidth">
          <el-input autocomplete="off" v-model="form.nickname"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogAdd = false">取 消</el-button>
        <el-button type="primary" @click="addData">确 定</el-button>
      </div>
    </el-dialog>

    <el-table
      :data="getAdminList"
      style="width: 100%;margin-bottom: 20px;"
      row-key="id"
      border
      default-expand-all
    >
      <el-table-column prop="id" label="ID" width="50" sortable>
      </el-table-column>
      <el-table-column prop="login_name" label="用户名" width="100">
      </el-table-column>
      <el-table-column prop="nickname" label="昵称" width="200">
      </el-table-column>
      <el-table-column prop="rolename" label="权限" width="100">
      </el-table-column>
      <el-table-column prop="status" label="状态" width="100">
      </el-table-column>
      <el-table-column prop="guid" label="唯一状态码" width="280">
      </el-table-column>
      <el-table-column prop="ip" label="IP" width="180"> </el-table-column>
      <el-table-column prop="addtime" label="创建时间" width="180">
      </el-table-column>
      <el-table-column prop="lasttime" label="上一次登录时间">
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
        <el-form-item label="昵称" :label-width="formLabelWidth">
          <el-input
            autocomplete="off"
            v-model="nowListData.nickname"
          ></el-input>
        </el-form-item>
        <el-form-item label="权限" :label-width="formLabelWidth">
          <el-input
            autocomplete="off"
            v-model="nowListData.rolename"
          ></el-input>
        </el-form-item>
        <el-form-item label="状态" :label-width="formLabelWidth">
          <el-input autocomplete="off" v-model="nowListData.status"></el-input>
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
import { getData, deleteData, editData, addData } from "@/api/admin";
import { mapGetters } from "vuex";

export default {
  name: "Table",
  data() {
    return {
      //拿到数据
      getAdminList: [],
      //拿到数据总数
      count: 1,
      pagesize: 5,
      currpage: 1,
      nowListData: [],
      //表单数据直接用对象
      form: {
        login_name: "",
        password: "",
        nickname: ""
      },
      dialogFormVisible: false,
      dialogAdd: false,
      formLabelWidth: "120px",
      currentPage: 1
    };
  },
  created() {
    this.getData();
  },
  methods: {
    getData() {
      //直接通过api接口像后端发送请求
      getData(this.currentPage, this.pagesize).then(response => {
        this.getAdminList = response.data;
        this.count = response.count;
        console.log(this.count);
      });
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
    //新增管理员,写入后端数据库
    addData() {
      addData(this.form).then(response => {
        this.dialogAdd = false;
        this.form = {};
        this.getData();
      });

      // this.$router.go(0);
    },
    handleEdit(index, row) {
      this.dialogFormVisible = true;
      this.nowListData = row;
      console.log(this.nowListData.login_name);
    },
    handleDelete(index, row) {
      //直接通过api接口像后端发送请求
      deleteData(row.guid).then(response => {
        this.getData();
      });
      // this.$router.go(0);
      console.log(row.guid);
    },
    handleSizeChange(val) {
      this.pagesize = val;
      getData(this.currpage, val).then(response => {
        this.getAdminList = response.data;
        console.log(this.getAdminList);
      });
      console.log(`每页 ${val} 条`);
    },
    handleCurrentChange(val) {
      getData(val, this.pagesize).then(response => {
        this.getAdminList = response.data;
        console.log(this.getAdminList);
      });
      this.currpage = val;
      console.log(`当前页: ${val}`);
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
