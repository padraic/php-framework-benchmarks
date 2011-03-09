<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Hello extends Controller {

	public function action_index()
	{
		$this->response->body(View::factory('hello/index'));
	}

} // End Welcome

