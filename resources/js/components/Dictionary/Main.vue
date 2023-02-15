<template>
  <div>
    <h1 class="text-center">Dictionary</h1>
    <form class="container text-center" @submit.prevent="addWord">
      <input
        required
        type="text"
        class="form-control mb-4"
        v-model="original"
        placeholder="original"
      />
      <input
        required
        type="text"
        class="form-control mb-4"
        v-model="translate"
        placeholder="translate"
      />
      <Transition>
        <button class="btn btn-primary">
          <div v-if="loading" class="spinner-border" role="status">
            <span class="sr-only"></span>
          </div>
          <span v-if="!loading">Add Word</span>
        </button>
      </Transition>
    </form>
    <div>
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Original</th>
            <th scope="col">Translate</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(word, key) in words" :key="key">
            <th scope="row">{{ Number(key) + 1 }}</th>
            <td>{{ word.original }}</td>
            <td>{{ word.translate }}</td>
            <button class="btn btn-danger btn-trash" @click="deleteWord(word.id)">
              <i class="bi bi-trash"></i>
            </button>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  data: () => ({
    user: null,
    original: "",
    translate: "",
    words: [],
    loading: false,
  }),
  methods: {
    addWord() {
      this.loading = true;
      axios
        .post("api/word", {
          user_id: this.user.id,
          original: this.original,
          translate: this.translate,
        })
        .then((res) => {
          console.log(res.data);
          this.words.push(res.data);
          this.loading = false;
        });
    },
    getUser() {
      axios.get("api/user").then((res) => {
        this.user = res.data;
        this.getUserDictionary();
      });
    },
    getUserDictionary() {
      axios.get("api/word/" + this.user.id).then((res) => {
        this.words = Object.values(res.data);
      });
    },
    deleteWord(id) {
      if (confirm("Do you realy want to delete this word?")) {
        console.log(this.words);
        axios.delete("api/word/" + id).then((res) => {
          let words = this.words.filter((word) => {
            return Number(word.id) != Number(id)
          })
          this.words = words
        })
        
      }
    },
  },
  mounted() {
    this.getUser();
  },
};
</script>

<style>
/* we will explain what these classes do next! */
.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}

.btn-trash {
  color: black;
}

.btn-trash:hover {
  color: aliceblue;
}
</style>