<template>
  <div class="col-10 mx-auto">
    <h1 class="my-4">แสดงข้อมูลนะ</h1>
    <table class="table table-bordered">
      <tr>
        <th>id</th>
        <th>name</th>
        <th>status</th>
        <th>view</th>
      </tr>
      <tr v-for="user in users">
        <td>{{user.id}}</td>
        <td>{{user.name}}</td>
        <td>{{user.status}}</td>
        <td>
          <a class="btn btn-danger" type="button">ลบ</a>
        </td>
      </tr>
    </table>
    <br>
    <br>

    <div>เพิ่มข้อมูล</div>
    
    <div class="row">
      <div class="col-2">id</div>
      <div class="col-5">name</div>
      <div class="col-5">status</div>
    </div>
    <div class="row">
      <input class="col-2">
      <input class="col-5">
      <input class="col-5">
    </div>
    <br />
    <button class="btn btn-primary" type="button">เพิ่ม</button>
  </div>
</template>

<script>
export default {
  mounted() {
    this.getUserData();
  },
  methods: {
    getUserData() {
      axios.get("api/users").then((response) => {
        this.users = response.data;
      });
    },
  },
  data() {
    return {
      users: [],
      user: {
        id: 0,
        name: "",
        status: "",
      },
    };
  },
};
</script>
