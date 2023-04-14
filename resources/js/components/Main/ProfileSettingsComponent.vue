<template>
  <div v-if="user != []">
    <h1 class="text-center mt-3">Profile Settings</h1>
    <div class="text-center">
      <div>
        <span class="h3">Name: </span> <input class="m-2" type="text" name="name" v-model="user.name">
        <button class="btn btn-success br m-2">Save</button>
      </div>
      <div class="mt-5">
        <h2>Reset password</h2>
        <input class="m-2" type="password" name="old_password" placeholder="Old password">
        <input class="m-2" type="password" name="new_password" placeholder="New password">
        <button class="btn btn-warning m-2">Reset</button>
      </div>
    </div>
    <!-- <vue-avatar :width=400 :height=400 :rotation="rotation" :scale="scale" ref="vueavatar"
      @vue-avatar-editor:image-ready="onImageReady">
    </vue-avatar> -->
    <input type="file" @change="saveClicked($event)">
    <br>
    <input type="range" min=1 max=3 step=0.02 :value='scale' />
    <input type="range" min=1 max=3 step=0.02 :value='rotation' />
    <br>
    <button v-on:click="saveClicked">Click</button>
    <br>
    <img ref="image">
  </div>
</template>

<script>

import { VueAvatar } from 'vue-avatar-editor-improved'
export default {
  data: () => ({
    user: [],
    rotation: 0,
    scale: 1
  }),
  components: {
    VueAvatar
  },
  methods: {
    getUser() {
      axios.get("/sanctum/csrf-cookie").then((response) => {
        axios
          .get("/api/user")
          .then((res) => {
            this.user = res.data;
          })
          .catch((err) => { });
      });
    },
    changeName(name, id = this.user.id) {

    },
    // saveClicked() {
    //   console.log(this.$refs.vueavatar);
    //   // var img = this.$refs.vueavatar.getImageScaled()
    //   let image = img.toDataURL()
    //   this.$refs.image.src = image

    //   let ctx = image.getContext('2d')
    //   ctx.fillRect(0, 0, 100, 100);
    //   const imageData = canvas.toDataURL('image/png');

    //   // Создаем новый объект изображения
    //   const img = new Image();

    //   // Загружаем данные изображения в объект Image
    //   img.src = imageData;

    //   console.log(imageData);

    //   console.log(image);
    //   let fd = new FormData()
    //   fd.append('user', this.user.id)
    //   fd.append('image', image)
    //   axios.get('/sanctum/csrf-cookie').
    //     then(response => {
    //       axios.post('/api/image', fd)
    //         .then(res => {
    //           console.log(res.data);
    //         })
    //         .catch(err => {
    //         })
    //     });
    // },
    saveClicked($event){
      console.log($event.target.files[0]);
      let image = $event.target.files[0]
      let fd = new FormData()
      fd.append('user', this.user.id)
      fd.append('image', image)
      axios.get('/sanctum/csrf-cookie').
        then(response => {
          axios.post('/api/image', fd)
            .then(res => {
              console.log(res.data);
            })
            .catch(err => {
            })
        });
    },
    onImageReady() {
      this.scale = 1
      this.rotation = 0
    },
    onFileChange(e) {
      const files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.createImage(files[0]);
    },
    createImage(file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        this.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    async save() {
      const canvas = this.$refs.editor.getImageScaledToCanvas();
      const data = canvas.toDataURL('image/jpeg');
      const response = await axios.post('/avatar', { image: data });
      console.log(response.data.path);
    },
  },
  mounted() {
    this.getUser()
  }
}
</script>

<style></style>