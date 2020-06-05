<?php namespace App\Controllers;

use App\Models\CategoryModel;

class Category extends BaseController
{
	public function addSubLevel($id)
	{
        $category = new CategoryModel();
        if($id == 0)
            return json_encode($category->makeRoot());

        $model = (\Config\Database::connect())->table('categories');

        $categoryModel   = $model->where(['id'=> $id])->get(1)->getFirstRow(); 
        if($categoryModel){
            return json_encode($category->append($categoryModel));
        }
	}
   

}
