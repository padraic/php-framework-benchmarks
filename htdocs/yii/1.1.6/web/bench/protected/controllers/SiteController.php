<?php

class SiteController extends CController
{
    public $layout = false;
	public function actionHello()
	{
	    $this->render('hello');
	}
}

