<?php

use components\Db;

class ApiController
{

    public function __construct()
    {
        
        $this->db = new Db;
        $this->connect = $this->db->getConnection();

        $this->post = $this->db->postCheck();

    }

    public function actionGetUserWords()
    {               

        //$post = $this->post;

        $user_id = $_COOKIE["id"];

        echo $this->connect->q(" SELECT * FROM users_dictionary WHERE `user_id` = '$user_id' ")->json();

        return true;

    }

    public function actionAddWord()
    {
        $post = $this->post;

        $user_id = $_COOKIE["id"];

        $en = $post['en'];
        $ru = $post['ru'];
        $phrase = $post['phrase'];

        $this->connect->q("INSERT into users_dictionary SET en='$en', ru='$ru', user_id='$user_id', phrase='$phrase', rating=1 ");

        function to_json($a)
        {
            return json_encode($a, JSON_UNESCAPED_UNICODE);
        }

        echo to_json([
            "en"=> $en,
            "ru" => $ru,
            "phrase"=> $phrase,
            "rating"=> 1,
        ]);

        return true;
    }

    public function actionDelete()
    {

        $post = $this->post;
        $id = $post['id'];

        $this->connect->q("DELETE FROM users_dictionary WHERE id='$id'  ");

        return true;

    }

    public function actionUpdateRating()
    {
    
        $post = $this->post;
        $id = $post['id'];
        $rating = $post['input'];
        $value = $post['value'];
        

        $user_id = $_COOKIE["id"];

        $array = $this->connect->q(" SELECT * FROM users_dictionary WHERE `user_id` = '$user_id' ");
        echo $array->json();

        if($array->rating == 1){
            if($rating != 5){
                $this->connect->q(" UPDATE users_dictionary SET rating = rating + 1 WHERE id='$id' ");
            }
        }else{
            if($rating != 1){
                $this->connect->q(" UPDATE users_dictionary SET rating = rating - 1 WHERE id='$id' ");
            }
        }

        return true;

    }

    public function actionUpdate()
    {

        $post = $this->post;
        $input = $post['input'];
        $value = $post['value'];
        $id = $post['id'];

        $this->connect->q(" UPDATE users_dictionary SET $input = '$value' WHERE id='$id' ");

        return true;
    }

}