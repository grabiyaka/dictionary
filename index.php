<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <base href="http://localhost/projects/en/">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style2.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script>
      function post(url, data, callback) {
        let xhr = new XMLHttpRequest();

        xhr.open("POST", url);

        xhr.send(data);

        xhr.onload = () => {
          callback(xhr.response);
        };
      }

    </script>
</head>
<body>
    <div id="app" class="container mt-4">
        <?php 
            if(!$_COOKIE):
        ?>
        <div class="row">
           <div v-show="auth" class="col">
           <h1>Форма регистрации</h1>
            <form action="api-reg/check.php" method="post">
                <input type="text" class="form-control" name="login" id="login" placeholder="логин" required><br>
                <input type="text" class="form-control" name="pass" id="pass" placeholder="пароль" required><br>
                <button type="submit" class="btn btn-success">Зарегестрироваться</button>
            </form>
            <button @click="auth = null">Уже есть аккаунт?</button>
           </div>
           <div v-show="!auth" class="col"> 
           <h1>Авторизаваться</h1>
            <form action="api-reg/auth.php" method="post">
                <input type="text" class="form-control" name="login" id="login" placeholder="логин" required><br>
                <input type="text" class="form-control" name="pass" id="pass" placeholder="пароль" required><br>
                <button type="submit" class="btn btn-success">Войти</button>
            </form>
            <button @click="auth = 1">Нет аккаунта?</button>
           </div>
        </div>
        <?php else: ?>
            <header>
                <div id="user">
                    <?=$_COOKIE['user']; ?>
                </div>
            </header>
            <p>Привет <?=$_COOKIE['user']; ?> <?=$_COOKIE['id']; ?>. Что бы выйти <a href="api-reg/exit.php">нажмите сюда</a></p>
            <h3>Что бы пройти тест <a href="test.php">нажмите сюда</a> </h3>
            <div class="header">
            <h1>Today is <?php echo date("d-m-Y") ?></h1>
            <h1><?php echo date("l").', the '.date("d").' of '.date("F") ?></h1>
        </div>
        <div class="formAdd">
            <a href="https://translate.google.com/?hl=ru">Google translate</a> <br> <br>
            <form @submit.prevent="add($event)">
                <input type="text" name="en" placeholder="en" required>
                <input type="text" name="ru" placeholder="ru" required>
                <input type="text" name="phrase" placeholder="phrase" >
                <button>add</button>
            </form>
            <button @click="editWord = 1" v-if="editWord == 0" class="edit">Редактировать/Удалить</button>
            <button @click="editWord = 0" v-if="editWord == 1" class="edit">Отмена</button>
        </div>
        <div class="search">
            <input type="text" v-model="search" placeholder="search...">
        </div>
        <div class="body">
            <table class="table">                
                <tr v-for="(word, index) in sortedApi" v-show="word.visible">
                    <td class="word" class="tr">
                        <h3 v-if="editWord == 0" class="words"> {{ word.en }} </h3>
                        <input @keyup="updateWord(word.id, $event)" name="en" v-if="editWord == 1" type="text" :value="word.en">
                        <button v-if="editWord == 1" @click="deleteWord(word.id)">удалить</button>
                        <div>
                           
                            <hr>
                            <h3 v-if="editWord == 0" class="words"> {{ word.ru }} </h3>  
                            <input @keyup="updateWord(word.id, $event)" name="ru" v-if="editWord == 1" type="text" :value="word.ru">
                            <hr>
                            <h3 v-if="editWord == 0" class="words"> {{ word.phrase }} </h3>  
                            <input @keyup="updateWord(word.id, $event)" name="phrase" v-if="editWord == 1" type="text" :value="word.phrase">
                        </div>
                         
                    </td>
                    
                    <td class="rating">
                        <span @click="updateRating(word.id, n, index)" v-for="n in 5" :class="{active: n <= word.rating}">★</span>
                    </td>
                </tr>
               
                
                <!-- <h3>Nothing found/Ничего не найденно(</h3> -->

                <tr v-if="!sortedApi.length">
                    <td class="word">
                        <h3 class="words"> Nothing found </h3>
                    </td>
                    <td class="word">
                        <h3 class="words"> Ничего не найдено </h3>   
                    </td>
                    
                </tr>
            </table>
        </div>

        <?php endif; ?>
    
    </div>
    <script>
       let app = new Vue({
            el:"#app",
            data:{
                api: [],
                editWord: 0,
                search: null,
                auth: null
            },
            computed: {
                sortedApi(){
                    let output = []
                    for(key in this.api){
                        let visible = true
                        if(this.search){
                            visible = this.api[key].en.toLowerCase().includes( this.search.toLowerCase() ) || 
                                this.api[key].ru.toLowerCase().includes( this.search.toLowerCase() ) 
                        }
                        output[key] = {
                            visible: visible,
                            ...this.api[key]
                        }
                    }
                    // console.log(output)
                    return output.sort((a, b) => (a.rating > b.rating) ? 1: -1)
                }
            },
            methods:{
                get(){
                    post("api/get.php", null, msg=>{
                        this.api = JSON.parse(msg)
                        // console.log(this.api)
                    })
                },
                add($event) {
                    let fd = new FormData($event.target);
                    post("api/add.php", fd, (msg) => {
                    this.api.push(JSON.parse(msg));
                    $event.target.reset();
                    alert("add");
                    });
                    
                },
                updateWord(id, $event) {
                    let fd = new FormData();
                    fd.append("id", id);
                    fd.append("value", $event.target.value);
                    fd.append("input", $event.target.name)
                    post("api/update.php", fd, (msg) => {});
                },
                deleteWord(id) {
                    if (confirm('Ты удаляешь это слово?')){
                        let fd = new FormData();
                        fd.append("id", id);
                        post("api/delete.php", fd, (msg) => {
                        this.api = this.api.filter(word => word.id !== id);
                        this.searchApi = this.searchApi.filter(word => word.id !== id);
                        });
                        alert("Удалено!");
                    }
                },
                updateRating(id, n, index){
                    let fd = new FormData();
                    fd.append("id", id);
                    fd.append("value", n);
                    fd.append("input", "rating")
                    post("api/update.php", fd, (msg) => {
                        this.api.forEach(e => {
                            if(e.id == id){
                                e.rating = n
                            }
                        })
                    });
                }
            },
            beforeMount(){
                this.get()
            }
        })
    </script>    
   
</body>
</html>