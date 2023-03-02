<template>
  <div>
    <h1 class="text-center">Your Dictionary</h1>
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
      <div>
        Associations:
        <input v-for="(association, key) in associations" v-model="associations[key]" :key="key" class="form-control mb-4" type="text" >
        <button @click.prevent="addAssociation" class="bi bi-plus-circle-dotted btn btn-success mb-3"> Add</button>
      </div>
      <div>
        Sentences:
        <input v-for="(sentence, key) in sentences" v-model="sentences[key]" :key="key" class="form-control mb-4" type="text" >
        <button @click.prevent="addSentence" class="bi bi-plus-circle-dotted btn btn-success mb-3"> Add</button>
      </div>
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
          <tr class="word-element" v-for="(word, key) in words" :key="key" :class="{'bg-danger': word.deleted }" @click="$router.push('word/' + user.id + '/' + word.id)">
            <th scope="row">{{ Number(key) + 1 }}</th>
            <td>{{ word.original }}</td>
            <td>{{ word.translate }}</td>
            <td><button type="button" class="btn-close word-delete" aria-label="Close" @click.stop="deleteWord(word.id, key)"></button></td>
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
    sentences: [
      ""
    ],
    associations: [
      ""
    ]
  }),
  methods: {
    addWord() {
      this.loading = true;
      axios
        .post("api/word", {
          user_id: this.user.id,
          original: this.original,
          translate: this.translate,
          sentences: this.sentences,
          associations: this.associations
        })
        .then((res) => {
          console.log(res.data);
          this.words.push(res.data);
          this.original = ''
          this.translate = ''
          this.sentences = [""]
          this.associations = [""]
          this.loading = false;
        });
    },
    addSentence(){
      console.log(this.sentences.slice(-1));
      if(this.sentences.slice(-1)[0] != ""){
        this.sentences.push("")
      }
    },
    addAssociation(){
      console.log(this.associations.slice(-1));
      if(this.associations.slice(-1)[0] != ""){
        this.associations.push("")
      }
    },
    getUser() {
      axios.get("api/user").then((res) => {
        this.user = res.data;
        this.getUserDictionary();
      });
    },
    getUserDictionary() {
      axios.get("api/word/user/" + this.user.id).then((res) => {
        this.words = Object.values(res.data);
      });
    },
    deleteWord(id, key) {
      if (confirm("Do you realy want to delete this word?")) {
        this.words[key].deleted = true
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

.word-element{
  max-width: 100%;
}

.word-element:hover{
  transition: all ease .1s;
  background: #00000033;
}

.word-delete{
  float: right;
}

table{
  border-collapse: collapse;
}
</style>