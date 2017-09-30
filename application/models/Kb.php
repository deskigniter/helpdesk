<?php
/**
 * @package EvolutionScript
 * @author: EvolutionScript S.A.C.
 * @Copyright (c) 2017, EvolutionScript.com
 * @link http://www.evolutionscript.com
 */

class Kb extends CI_Model
{
    private $private_cats;
    public function getCategory($cat_id, $private=false){
        if(!$private){
            if(in_array($cat_id, $this->privateCategories()))
            {
                return null;
            }
            $this->db->where('public', 1);
        }

        $q = $this->db->where('id', $cat_id)
            ->get('knowledgebase_category');
        if($q->num_rows() == 0){
            return null;
        }
        return $q->row();
    }
    public function getCategories($parent=0, $private=false)
    {
        if(!$private){
            $this->db->where('public', 1);
        }
        $q = $this->db->where('parent', $parent)
            ->order_by('position','asc')
            ->get('knowledgebase_category');
        if($q->num_rows() == 0){
            return null;
        }
        $r = $q->result();
        $q->free_result();
        return $r;
    }


    public function getArticles($cat_id, $private=false)
    {
        if(!$private)
        {
            $this->db->where('public', 1);
        }

        $q = $this->db->select('id, title, content')
            ->where('category', $cat_id)
            ->get('articles');
        if($q->num_rows() == 0)
        {
            return null;
        }
        $result = $q->result();
        $q->free_result();
        return $result;
    }
    /*
     *
     * ------------------
     * Private Categories
     * -------------------
     */
    public function privateCategories()
    {
        if(!$this->private_cats)
        {
            $this->private_cats = array();
            $q = $this->db->select('id, parent, public')
                ->order_by('public','asc')
                ->order_by('parent','asc')
                ->get('knowledgebase_category');
            if($q->num_rows() > 0)
            {
                foreach($q->result() as $r)
                {
                    if($r->public == 0){
                        if(!in_array($r->id,$this->private_cats)){
                            array_push($this->private_cats,$r->id);
                        }
                    }elseif(in_array($r->parent, $this->private_cats)){
                        array_push($this->private_cats,$r->id);
                    }
                }
                $q->free_result();
            }
        }
        return $this->private_cats;
    }

    /*
     *
     * ------------------
     * Popular KB
     * ------------------
     */
    public function getPopular($private=false)
    {
        if(!$private)
        {
            foreach($this->privateCategories() as $cat)
            {
                $this->db->where('category!=', $cat);
            }
            $this->db->where('public', 1);
        }
        $q = $this->db->select('id, title, category')
            ->order_by('views','desc')
            ->limit($this->settings->get('knowledgebase_mostpopulartotal'))
            ->get('articles');
        if($q->num_rows() == 0){
            return null;
        }
        $r = $q->result();
        $q->free_result();
        return $r;
    }


    /*
     *
     * ------------------
     * Newest Kb
     * ------------------
     */
    public function getNewest($private=false)
    {
        if(!$private)
        {
            foreach($this->privateCategories() as $cat)
            {
                $this->db->where('category!=', $cat);
            }
            $this->db->where('public', 1);
        }

        $q = $this->db->select('id, title, category')
            ->order_by('date','DESC')
            ->limit($this->settings->get('knowledgebase_newesttotal'))
            ->get('articles');

        if($q->num_rows() == 0){
            return null;
        }
        $r = $q->result();
        $q->free_result();
        return $r;
    }


    /*
     * --------------------------------------------
     * Get children categories from category parent
     * --------------------------------------------
     */
    public function categoryChildren($cat_id, $private=false)
    {
        $children = array();
        if(!$private)
        {
            $this->db->where('public', 1);
        }
        $q = $this->db->select('id, parent')
            ->where('parent', $cat_id)
            ->get('knowledgebase_category');
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $r)
            {
                if($r->parent != 0)
                {
                    $children[] = $r->id;
                    if($new_parent = $this->categoryChildren($r->id, $private))
                    {
                        $children = array_merge($children, $new_parent);
                    }
                }
            }
            $q->free_result();
            return $children;
        }else{
            return null;
        }
    }

    /*
     *
     * ----------------------------------------
     * Category parents used for the breadcrumb
     * ---------------------------------------
     */
    public function categoryParents($parent_id, $private=false)
    {
        if($parent_id == 0){
            return null;
        }
        $parents = array();
        if(!$private){
            $this->db->where('public', 1);
        }
        $q = $this->db->where('id', $parent_id)
            ->get('knowledgebase_category');
        if($q->num_rows() == 0){
            return null;
        }
        $r = $q->row();
        $parents[$r->id] = $r->name;
        if($new_parent = $this->categoryParents($r->parent))
        {
            $parents = $new_parent+$parents;
        }
        return $parents;
    }

    /*
     *
     * -------------------------
     * Count Articles
     * -------------------------
     */
    public function countArticles($cat_id, $private=false)
    {

        if(!$category_list = $this->categoryChildren($cat_id, $private))
        {
            $category_list = array();
        }

        $category_list[] = $cat_id;

        foreach($category_list as $c)
        {
            $this->db->or_where('category', $c);
        }

        if(!$private)
        {
            $this->db->where('public', 1);
        }

        return $this->db->count_all_results('articles');
    }

    public function categoryArticles($cat_id, $limit=false, $private=false)
    {

        if(!$category_list = $this->categoryChildren($cat_id, $private))
        {
            $category_list = array();
        }

        $category_list[] = $cat_id;

        foreach($category_list as $c)
        {
            $this->db->or_where('category', $c);
        }

        if(!$private)
        {
            $this->db->where('public', 1);
        }

        if($limit)
        {
            $this->db->limit($this->settings->get('knowledgebase_articlesundercat'));
        }
        $q = $this->db->select('id, title, content')
            ->order_by('date','desc')
            ->get('articles');
        if($q->num_rows() == 0){
            return null;
        }
        $r = $q->result();
        $q->free_result();
        return $r;
    }

    /*
     *
     * ---------------
     * Retrieve an Article
     * -------------------
     */

    public function getArticle($id, $private=false)
    {
        if(!$private)
        {
            $this->db->where('a.public', 1)
                ->where('c.public', 1);
        }
        $q = $this->db->select('a.*, c.id as cat_id, c.name as cat_name')
            ->where('a.id', $id)
            ->from('articles as a')
            ->join('knowledgebase_category as c', 'c.id=a.category')
            ->get();
        if($q->num_rows() == 0)
        {
            return null;
        }
        $result = $q->row();
        $q->free_result();
        if(!$private){
            if(in_array($result->category, $this->privateCategories())){
                return null;
            }
        }


        $this->db->set('views','views+1', false)
            ->where('id', $id)
            ->update('articles');
        return $result;
    }
}