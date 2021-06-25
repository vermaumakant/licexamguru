<template>
  <div class="toolbar d-flex space-between d-sm-justify-center pl-md-10">
    <img src="/images/logo.png" alt="Vamaship" width="140px" height="30px;" />
    <el-dropdown class="username" @command="handleCommand" v-if="user">
      <span class="el-dropdown-link">
        {{ user.name }} <i class="el-icon-arrow-down el-icon--right"></i>
      </span>
      <el-dropdown-menu slot="dropdown">
        <el-dropdown-item command="logout">Logout</el-dropdown-item>
      </el-dropdown-menu>
    </el-dropdown>
  </div>
</template>
<script>
import { logout, me } from "@api/auth";
import Bus from "@/event-bus";

export default {
  data() {
    return {
      user: null,
    };
  },
  mounted() {
    Bus.$on("authenticated", this.fetchUser);
    this.fetchUser();
  },
  methods: {
    async fetchUser() {
      try {
        const response = await me();
        this.user = response.data.user;
      } catch (error) {
        console.log(
          error.response.status == 401 ? "Unauthorized" : error.response
        );
      }
    },
    async handleCommand(command) {
      await logout();
      Cookies.remove("token", { domain: ".vamaship.com", path: "/" });
      this.user = null;
      this.$router.push("/redirection");
    },
  },
};
</script>
<style lang="scss" scoped>
.toolbar {
  background: rgb(6, 97, 201);
  margin: 0px;
  padding: 10px;
}
.username {
  font-family: Arial, Helvetica, sans-serif;
  font-weight: 400;
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
}
</style>