<template>
  <div>
    <div class="mx-auto text-center">
      <h1>Reset password</h1>
      <form v-on:submit.prevent="getResetLink">
        <div class="">
          <div>
            <input
              type="email"
              class="mb-3 mt-3"
              v-model="email"
              placeholder="Enter your email"
            />
          </div>
          <button class="btn btn-primary">Send an email</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data: () => ({
    email: "",
    password: "",
    errors: null,
    loading: false,
    reset: "",
  }),
  methods: {
    getResetLink() {
      this.$store.commit("setLoading", true);
      axios
        .post("/password/email", {
          email: this.email,
        })
        .then((res) => {
          console.log(res);
          this.reset = res.data.message;
          this.loading = false;
          this.$store.commit("setLoading", false);
        })
        .catch((err) => {
          this.$store.commit("setLoading", false);
          const error = err.response.data.message;
          alert(error)
        });
    },
  },
};
</script>

<style>
</style>