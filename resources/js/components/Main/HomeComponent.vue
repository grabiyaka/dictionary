<template>
  <div class="text-center tab-content mx-auto">
    <h1 class="text-center">Home Page</h1>
    <form class="form-outline mb-4" @submit.prevent="getWord()">
      <input
        v-model="word"
        type="text"
        class="form-control mb-2"
        autocomplete="off"
        placeholder="Enter any word"
      />
      <button class="btn btn-primary">Get Info</button>
    </form>
    <div v-if="activeWord">
      {{ activeWord }}
      <audio
        v-if="activeWord"
        :src="activeWord[0].phonetics[0].audio"
        controls
      ></audio>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data: () => ({
    activeWord: null,
    word: "",
  }),
  methods: {
    async getWord() {
      if (true) {
        this.activeWord = null;
        this.$store.commit("setLoading", true);
        try {
          await axios.get("api/get/word/" + this.word).then((res) => {
            this.activeWord = res.data;
          });
        } catch (error) {
          alert("Word not found, pleace try again later");
        }
        await this.$store.commit("setLoading", false);
      }
    },
  },
  mounted() {
  },
};
</script>

<style>
</style>