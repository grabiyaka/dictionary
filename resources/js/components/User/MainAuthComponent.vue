<template>
  <div>
    <div>
      <NavComponent></NavComponent>
    </div>
    <transition name="slide" mode="out-in">
      <div>
        <LoginComponent v-if="mainComponent == 'login'"></LoginComponent>
        <RegisterComponent v-if="mainComponent == 'register'"></RegisterComponent>
      </div>
    </transition>
  </div>
</template>

<script>
import axios from "axios";
import NavComponent from "./NavComponent.vue";
import LoginComponent from "./LoginComponent.vue";
import RegisterComponent from "./RegisterComponent.vue";

export default {
  data() {
    return {
      mainComponent: "login",
    };
  },
  components: {
    NavComponent,
    LoginComponent,
    RegisterComponent,
  },
  methods: {

  },
};
</script>

<style lang="scss">
.tab-content{
  max-width: 500px;
}
</style>