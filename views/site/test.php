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
    <script src="templates/js/test.js"></script>
</body>
</html>