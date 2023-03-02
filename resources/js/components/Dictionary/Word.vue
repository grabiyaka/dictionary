<template lang="">
<div>
    <h2 class="text-center">{{ word.original }}</h2>
    <button class="edit-button" @click="edit = !edit">Edit</button>
    <div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Original</th>
                    <th scope="col">Translate</th>
                </tr>
            </thead>
            <tbody>
                <tr class="" :class="{'bg-danger': word.deleted }">
                    <td v-if="!edit">{{ word.original }}</td>
                    <td v-if="edit"><input type="text" @change="updateElement($event, $route.params.word_id)" name="original" class="form-control" v-model="word.original"></td>
                    <td v-if="!edit">{{ word.translate }}</td>
                    <td v-if="edit"><input type="text" @change="updateElement($event, $route.params.word_id)" name="translate" class="form-control" v-model="word.translate"></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div :class="{'text-center': edit}" class="border p-3" v-if="sentences.length">
        <h3 class="text-center"> Sentences: </h3>
        <div v-for="(sentence, key) in sentences" :key="key">
            <div v-if="!edit">{{key + 1}}: {{ sentence.content }}</div>
            <div v-if="edit" style="display: block;" id="rulesformitem" class="formitem text-center">
                <label for="rules" id="ruleslabel">#{{ key + 1 }}</label>
                <div class="textwrapper"><textarea @change="updateElement($event, sentence.id)" name="sentence" v-model="sentences[key].content" cols="2" rows="5" id="rules" /></div>
                </div>
            </div>
            <button v-if="edit" @click.prevent="addSentence" class="bi bi-plus-circle-dotted btn btn-success mb-3"> Add</button>
        </div>
        <div :class="{'text-center': edit}" class="border p-3 " v-if="associations.length">
            <h3 class="text-center"> Associations: </h3>
            <div v-for="(association, key) in associations" :key="key">
                <div v-if="!edit">{{key + 1}}: {{ association.content }}</div>
                <div v-if="edit" style="display: block;" id="rulesformitem" class="text-center">
                    <label for="rules" id="ruleslabel">#{{ key + 1 }}</label>
                    <div><input type="text" @change="updateElement($event, association.id)" name="association" class="form-control" v-model="associations[key].content" /></div>
                </div>
            </div>
            <button v-if="edit" @click.prevent="addAssociation" class="bi bi-plus-circle-dotted btn btn-success mb-3 mt-2"> Add</button>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        edit: false,
        word: {},
        sentences: [],
        associations: [],
    }),
    methods: {
        updateElement($event, id) {
            let name = $event.target.name
            let value = $event.target.value
            axios.post("api/word/update", {
                name,
                value,
                id
            }).then(res => {})
        },

        addSentence() {
            console.log(this.sentences.slice(-1)[0]);
            if (this.sentences.slice(-1)[0].content != "") {
                this.sentences.push({content: "", word_id: this.word.id})
            }
        },
        addAssociation() {
            if (this.associations.slice(-1)[0].content != "") {
                this.associations.push({content: "", word_id: this.word.id})
            }
        },
    },
    mounted() {
        axios.get("api/word/" + this.$route.params.word_id).then((res) => {
            this.word = res.data[0];
            this.sentences = res.data[1];
            this.associations = res.data[2];
        });
    }
};
</script>

<style lang="scss">
textarea {
    width: 100%;
}

.textwrapper {
    border: 1px solid #999999;
    margin: 5px 0;
    padding: 3px;
}

.edit-button {
    border-radius: 50%;
    width: 50px;
    height: 50px;
    position: fixed;
    top: 60px;
    right: 10px;
    border: solid black 2px;
    transition: all ease .2s;

    &:hover {
        background: rgba(47, 47, 243, 0.658);
    }
}
</style>
