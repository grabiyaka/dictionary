<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <base href="http://localhost/projects/en/">
    <script>
        function post(url, data, callback) {
          let xhr = new XMLHttpRequest();
  
          xhr.open("POST", url);
  
          xhr.send(data);
  
          xhr.onload = () => {
            callback(xhr.response);
          };
        }
  
        Array.prototype.findObjectByValue = function (key, searched) {
          let newArr = this.filter((e) => e[key] == searched);
  
          if (newArr.length) {
            return newArr[0];
          }
        };
      </script>
      <style>
        #app{
            display: flex;
            text-align: center;
            justify-content: center;
        }
      </style>
</head>
<body>
    <div id="app">
        <?php 
            if(!$_COOKIE):
        ?>
        <?php header('Location: /projects/en/'); ?>
        <?php else: ?>
        <div v-if="api.length">
            <h2>Вам знакомо это слово?!?!?! "{{ api[selected].en }}"</h2>
            <button @click="updateTest(api[selected].id, 1, api[selected].rating), statistics++">Конечно знаю! я что тупой по твоему?</button>
            <button @click="updateTest(api[selected].id, 0, api[selected].rating), statistics--">Что ты прикопался?</button>
            <br> 
            <div v-for="rating in api">
                {{ rating.en }}:
                {{rating.rating}}
            </div>
            <hr>
            <div>
                {{ selected }} <br>
                {{ api[selected] }} <br>
                {{ prev }} <br>
                {{ statistics }}
            </div>
        </div>
        <div v-if="!api.length">
            <h1>Ничего нету</h1>
            <h2><a href="">Вернуться назад</a></h2>
        </div>
        <?php endif; ?>
    </div>
    <script>
        let app = new Vue({
            el:"#app",
            data:{
                api: [],
                selected: null,
                prev: [],
                statistics: 0
            },
            computed:{
                
            },
            methods:{
                get(){
                    post("api/get.php", null, msg=>{
                        this.api = JSON.parse(msg)
                        this.selected = this.getRandom(0, this.api.length - 1)
                        this.prev.push(this.selected)
                        // console.log(this.api)
                    })
                },
                getStart(){

                },
                getRandom(min, max){
                    return Math.floor(Math.random() * (max - min + 1) + min)
                },
                draw(min, max){
                    this.selected = this.getRandom(min, max)
                    if(this.prev.includes(this.selected)){
                        if(this.prev.length <= (max - min)){
                            this.draw(min, max)
                        }else{
                            if(this.statistics > 0){
                                alert("Ты не такой тупой как я думал)")
                            }else if(this. statistics == 0){
                                alert("Никакого прогресса!")
                            }else{
                                alert("Ты слишком туп для этого мира...")
                            }
                            
                            window.location.href = ""
                        }
                    }else{
                        this.prev.push(this.selected)                    
                    }
                },
                updateTest(id, e, rating){
                    let fd = new FormData();
                    fd.append("id", id);
                    fd.append("e", e);
                    fd.append("rating", rating)
                    post("api/update-rating.php", fd, (msg) => {
                        this.api = JSON.parse(msg)
                        this.draw(0, this.api.length - 1)
                        
                    });
                },
                // again(ololo){
                //     this.selected = Math.ceil(Math.random() * this.api.length) - 1
                //     console.log(ololo)
                //     if(this.selected == ololo){
                //         this.again(ololo)
                //     }
                // }
            },
            beforeMount(){
                this.get()
            }
        })
    </script>
</body>
</html>