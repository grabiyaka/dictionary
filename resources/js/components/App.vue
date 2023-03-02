<script>
import { RouterLink, RouterView } from "vue-router";
import LoadingComponent from "./Modals/LoadingComponent.vue";
import Header from "./Layouts/Header.vue";
export default {
  components: { Header, LoadingComponent },
  data: () => ({}),
  mounted() {},
};
</script>
<template>
  <Header ref="header" />
  <LoadingComponent></LoadingComponent>
  <router-view v-slot="{ Component }">
    <transition name="slide" mode="out-in">
      <div class="mb-5" id="viewbox" :key="$route.path">
        <component class="container" :is="Component"></component>
      </div>
    </transition>
  </router-view>
</template>
    
<style lang="scss">
@import url("/node_modules/bootstrap-icons/font/bootstrap-icons.css");
@import "/node_modules/bootstrap/scss/bootstrap";

body {
  padding: 0;
  margin: 0;
}

.slide-enter-active {
  transition: all 0.3s ease;
}
.slide-leave-active {
  transition: all 0.4s ease;
}
.slide-enter-from,
.slide-leave-to {
  opacity: 0;
  overflow: hidden;
  transform: scale(0.9);
}
</style>