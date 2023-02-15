<template>
  <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
    <li class="nav-item" role="presentation">
      <a
        class="nav-link"
        :class="{active: $parent.mainComponent == 'login'}"
        id="tab-login"
        data-mdb-toggle="pill"
        href=""
        role="tab"
        aria-controls="pills-login"
        aria-selected="true"
        @click.prevent="$parent.mainComponent = 'login'"
        >Login</a
      >
    </li>
    <li class="nav-item" role="presentation">
      <a
        class="nav-link"
        :class="{active: $parent.mainComponent == 'register'}"
        id="tab-register"
        data-mdb-toggle="pill"
        href=""
        role="tab"
        aria-controls="pills-register"
        aria-selected="false"
        @click.prevent="$parent.mainComponent = 'register'"
        >Register</a
      >
    </li>
  </ul>
</template>

<script>
export default {};
</script>

<style>
</style>