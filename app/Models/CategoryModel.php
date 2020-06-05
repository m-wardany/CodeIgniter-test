<?php namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table      = 'categories';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name', 'parent_id', 'seq', 'lft', 'rgt', 'depth', 'tree'];

    public function createName($tree, $parentCategory = null, $depth = null, $seq = null)
    {
        $alphabet = range('A', 'Z');
        $currentLetter = $alphabet[($tree-1)%25];
        
        if($parentCategory === null)
        return 'Category '.$currentLetter;
        $basicName = str_repeat("SUB ", $depth); 
        if($depth == 1)
            return $basicName.$currentLetter.$seq;
        $root = $this->getRootCat($parentCategory);
        $rootName = substr($root->name, strripos($root->name, ' ')+1,strlen($root->name));
        
        return $basicName.$rootName.'-'.$seq;
    }

    public function getRootCat($category)
    {
        $db = (\Config\Database::connect())->table('categories');
        if($category->depth <= 1) 
            return $category;
        while ($category->depth > 1 && $category != null) 
            $category = $db->where(['id'=> $category->parent_id])->get(1)->getFirstRow();
        
        return $category;
    }
     
    public function append($parentCategory)
    {
        $tree = $parentCategory->tree;
        $depth = $parentCategory->depth + 1;
        $seq  = ((\Config\Database::connect())->table('categories')->selectMax('seq')->where(['parent_id'=> $parentCategory->id])->get()->getFirstRow()->seq) + 1 ;
        $name = $this->createName($tree, $parentCategory, $depth, $seq);
        $lft = $this->db->query("SELECT lft FROM categories WHERE id = 1;")->getFirstRow()->lft;
        $nxtLft = $lft+1;
        $nxtRgt = $lft+2;
        $query = "UPDATE `categories` SET `lft` = `lft` + 2 WHERE `lft` > {$lft} AND `tree` = {$tree};";
        $this->db->query($query);
        $query2 = "UPDATE `categories` SET `rgt` = `rgt` + 2 WHERE `rgt` > {$lft} AND `tree` = {$tree};";
        $this->db->query($query2);
        $query3 = "INSERT INTO `categories`(name, lft, rgt, parent_id, tree, depth, seq) VALUES(\"$name\", {$nxtLft}, {$nxtRgt}, {$parentCategory->id}, {$tree}, {$depth}, {$seq})";
        return ['id'=> $this->runQuery($query3), 'name'=> $name, 'depth'=> $depth];
    }

    public function makeRoot()
    {
        $db = (\Config\Database::connect())->table('categories');
        $tree = ($db->selectMax('tree')->where(['parent_id'=> null])->get()->getFirstRow()->tree) +1;
        $seq  = ($db->selectMax('seq')->where(['parent_id'=> null])->get()->getFirstRow()->seq)+1;
        $name = $this->createName($tree);
        $query =  "INSERT INTO categories(name, tree, depth, seq) VALUES('{$name}', {$tree}, 0, {$seq});";
        return ['id'=> $this->runQuery($query), 'name'=> $name, 'depth'=> 0];
    }

    public function runQuery($query)
    {
        $prevId= (\Config\Database::connect())->table('categories')->selectMax('id')->get()->getFirstRow()->id;
        $debug = $this->db->query($query);
        $currId = (\Config\Database::connect())->table('categories')->selectMax('id')->get()->getFirstRow()->id;
        return $currId > $prevId ? $currId : null;
    }

}