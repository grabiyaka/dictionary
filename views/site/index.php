<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <base href="http://localhost/projects/en/">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="templates/css/style.css">
    <link rel="stylesheet" href="templates/css/style2.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="templates/js/post.js"></script>
</head>
<body>
    <div id="app" class="container mt-4">
        <?php 
            if(!isset($_COOKIE['user'])):
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
            <h3>Что бы пройти тест <a href="test">нажмите сюда</a> </h3>
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
    <script src="templates/js/index.js"></script>    
   
</body>
</html>