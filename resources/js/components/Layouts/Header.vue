<template>
  <header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary border-bottom px-3">
      <a class="navbar-brand" href="#">Navbar</a>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <router-link class="nav-item nav-link active" :to="{name: 'home'}"
            >Home <span class="sr-only"></span
          ></router-link>
          <router-link
            v-if="!$store.state.token.token"
            class="nav-item nav-link"
            :to="{ name: 'auth' }"
            >Auth</router-link
          >

          <router-link
            v-if="$store.state.token.token"
            class="nav-item nav-link"
            :to="{ name: 'profile' }"
            >Profile</router-link
          >
        </div>
      </div>
    </nav>
  </header>
</template>

<script>
import axios from "axios";
export default {
  mounted() {
    // this.$store.dispatch("setLanguage");
    this.$store.dispatch("getToken");
  },
  methods: {
    
  },
};
</script>

<style>
</style>