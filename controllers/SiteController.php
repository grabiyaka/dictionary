<?php 

use components\Db;

class SiteController
{

    public function actionIndex()
    {

       require_once ROOT . '/views/site/index.php';

       return true;

    }
    public function actionTest()
    {

        require_once ROOT . '/views/site/test.php';

        return true;

    }

}