<?php namespace App\Controllers;

use App\Models\CategoryModel;

class Home extends BaseController
{
	public function index()
	{
		$categories   = \Config\Database::connect()->table('categories')->where(['depth'=> 0])->orderBy('seq ASC')->get(); 
		
		return view('home', ['mainCategories'=> $categories->getResult()]);
	}

	public function test()
	{
		$str = "SUB SUB SUB SUB SUB SUB C1";
		$strpos = strripos($str, ' ');
		;
		var_dump($strpos);
		var_dump(substr($str, $strpos+1,strlen($str)));
	}
	
}
