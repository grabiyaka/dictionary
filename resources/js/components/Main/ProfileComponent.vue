<template>
  <div v-if="$store.getters.getToken" class="mx-auto">
    <h1 class="text-center">Profile</h1>
    <div v-if="user">
      <section class="">
        <div class="container py-5">
          <div class="row d-flex justify-content-center align-items-center">
            <div class="">
              <div class="" style="border-radius: 15px">
                <div class="card-body p-4">
                  <div class="d-flex text-black">
                    <div class="flex-shrink-0">
                      <img
                        :src="'/uploads/avatars/' + user.avatar"
                        alt="Generic placeholder image"
                        class="img-fluid"
                        style="width: 180px; border-radius: 10px"
                      />
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <h5 class="mb-1">{{ user.name }}</h5>
                      <p class="mb-2 pb-1" style="color: #2b2a2a">
                        {{ user.email }}
                      </p>
                      <div
                        class="d-flex justify-content-start rounded-3 p-2 mb-2"
                        style="background-color: #efefef"
                      >
                        <div>
                          <p class="small text-muted mb-1">Articles</p>
                          <p class="mb-0">41</p>
                        </div>
                        <div class="px-3">
                          <p class="small text-muted mb-1">Followers</p>
                          <p class="mb-0">976</p>
                        </div>
                        <div>
                          <p class="small text-muted mb-1">Rating</p>
                          <p class="mb-0">8.5</p>
                        </div>
                      </div>
                      <div class="d-flex pt-1">
                        <router-link
                          :to="{ name: 'profile.settings' }"
                          type="button"
                          class="btn btn-outline-primary me-1 flex-grow-1"
                        >
                          Settings
                        </router-link>
                        <router-link
                          :to="{ name: 'dictionary' }"
                          type="button"
                          class="btn btn-outline-primary me-1 flex-grow-1"
                        >
                          Dictionary
                        </router-link>
                        <button
                          type="button"
                          class="btn btn-danger flex-grow-1"
                          @click.prevent="logout()"
                        >
                          Exit
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
export default {
  data: () => ({
    user: null,
  }),
  methods: {
    getUser() {
      axios.get("/sanctum/csrf-cookie").then((response) => {
        axios
          .get("/api/user")
          .then((res) => {
            this.user = res.data;
          })
          .catch((err) => {});
      });
    },
    logout() {
      if (confirm("exit" + "?")) {
        axios.post("/logout").then((res) => {
          localStorage.removeItem("x_xsrf_token");
          this.$store.dispatch("getToken");
          this.$router.push({ name: "home" });
        });
      }
    },
  },
  mounted() {
    this.getUser();
  },
};
</script>

<style>
</style>