<template>
  <div>
    <!-- Pills content -->
    <div class="tab-content mx-auto">
      <div
        class="tab-pane fade show active"
        id="pills-login"
        role="tabpanel"
        aria-labelledby="tab-login"
      >
        <form class="text-center mx-auto">
          <!-- Email input -->
          <div class="form-outline mb-4">
            <input v-model="email" type="email" id="loginName" class="form-control" />
            <label class="form-label" for="loginName">Email</label>
          </div>

          <div class="form-outline mb-4">
            <input v-model="name" type="email" id="loginName" class="form-control" />
            <label class="form-label" for="loginName">Username</label>
          </div>

          <!-- Password input -->
          <div class="form-outline mb-4">
            <input v-model="password" type="password" id="loginPassword" class="form-control" />
            <label class="form-label" for="loginPassword">Password</label>
          </div>

          <div class="form-outline mb-4">
            <input v-model="password_confirmation" type="password" id="loginPassword" class="form-control" />
            <label class="form-label" for="loginPassword">Confirm Password</label>
          </div>


          <!-- Submit button -->
          <button @click.prevent="register" type="submit" class="btn btn-primary btn-block mb-4">
            Sign up
          </button>

        </form>
      </div>
      <div
        class="tab-pane fade"
        id="pills-register"
        role="tabpanel"
        aria-labelledby="tab-register"
      >
        <form>
          <div class="text-center mb-3">
            <p>Sign up with:</p>
            <button type="button" class="btn btn-link btn-floating mx-1">
              <i class="fab fa-facebook-f"></i>
            </button>

            <button type="button" class="btn btn-link btn-floating mx-1">
              <i class="fab fa-google"></i>
            </button>

            <button type="button" class="btn btn-link btn-floating mx-1">
              <i class="fab fa-twitter"></i>
            </button>

            <button type="button" class="btn btn-link btn-floating mx-1">
              <i class="fab fa-github"></i>
            </button>
          </div>

          <p class="text-center">or:</p>

          <!-- Name input -->
          <div class="form-outline mb-4">
            <input type="text" id="registerName" class="form-control" />
            <label class="form-label" for="registerName">Name</label>
          </div>

          <!-- Username input -->
          <div class="form-outline mb-4">
            <input type="text" id="registerUsername" class="form-control" />
            <label class="form-label" for="registerUsername">Username</label>
          </div>

          <!-- Email input -->
          <div class="form-outline mb-4">
            <input type="email" id="registerEmail" class="form-control" />
            <label class="form-label" for="registerEmail">Email</label>
          </div>

          <!-- Password input -->
          <div class="form-outline mb-4">
            <input type="password" id="registerPassword" class="form-control" />
            <label class="form-label" for="registerPassword">Password</label>
          </div>

          <!-- Repeat Password input -->
          <div class="form-outline mb-4">
            <input
              type="password"
              id="registerRepeatPassword"
              class="form-control"
            />
            <label class="form-label" for="registerRepeatPassword"
              >Repeat password</label
            >
          </div>

          <!-- Checkbox -->
          <div class="form-check d-flex justify-content-center mb-4">
            <input
              class="form-check-input me-2"
              type="checkbox"
              value=""
              id="registerCheck"
              checked
              aria-describedby="registerCheckHelpText"
            />
            <label class="form-check-label" for="registerCheck">
              I have read and agree to the terms
            </label>
          </div>

          <!-- Submit button -->
          <button type="submit" class="btn btn-primary btn-block mb-3">
            Sign in
          </button>
        </form>
      </div>
    </div>
  </div>
</template>
  
  <script>
import axios from "axios";
export default {
  name: "Registration",
  props: ["btnClass"],
  data() {
    return {
      email: null,
      name: null,
      password: null,
      password_confirmation: null,
      modal: false,
    };
  },
  mounted() {
    let date = new Date();
    date.setDate(date.getDate() + 14);
  },
  methods: {
    formatDate(date) {
      var d = new Date(date),
        month = "" + (d.getMonth() + 1),
        day = "" + d.getDate(),
        year = d.getFullYear();
      if (month.length < 2) month = "0" + month;
      if (day.length < 2) day = "0" + day;
      return [year, month, day].join("-");
    },
    register() {
      if (
        this.email !== null &&
        this.email !== "" &&
        this.password !== null &&
        this.password !== ""
      ) {
        axios.get("/sanctum/csrf-cookie").then((response) => {
          let validEmail =
            /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
          let passw = /^[A-Za-z]\w{7,14}$/;
          if (this.email.match(validEmail)) {
            if (this.password.match(passw)) {
              if (this.password === this.password_confirmation) {
                if (this.name !== "" && this.name !== null) {
                  let period = new Date();
                  period.setDate(period.getDate() + 14);
                  axios
                    .post("/register", {
                      email: this.email,
                      name: this.name,
                      password: this.password,
                      password_confirmation: this.password_confirmation,
                      remember: 1,
                      period: this.formatDate(period),
                    })
                    .then((res) => {
                      localStorage.setItem(
                        "x_xsrf_token",
                        res.config.headers["X-XSRF-TOKEN"]
                      );
                      this.$store.dispatch("getToken");
                      this.$router.push({ name: "cabinet" });
                    })
                    .catch((err) => {});
                } else {
                  alert('name is shit');
                }
              } else {
                alert('password is not confirm');
              }
            } else {
              alert('wrown password');
            }
          } else {
            alert('email is shit');
          }
        });
      } else {
        alert('fill fields');
      }
    },
  },
};
</script>
      
  <style>
</style>