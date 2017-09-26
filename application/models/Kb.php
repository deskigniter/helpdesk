<?php
/**
 * @package EvolutionScript
 * @author: EvolutionScript S.A.C.
 * @Copyright (c) 2017, EvolutionScript.com
 * @link http://www.evolutionscript.com
 */

class Kb extends CI_Model
{
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

        while($r = $db->fetch_array($q)){
            $r['total_articles'] = $db->fetchOne("SELECT COUNT(id) AS total FROM ".TABLE_PREFIX."articles WHERE category=".$r['id']." AND public=1");
            $r['url'] = getUrl('knowledgebase',$r['id'],array(strtourl($r['name'])));
            if($r['total_articles'] > 0){
                $aq = $db->query("SELECT id, title FROM ".TABLE_PREFIX."articles WHERE category=".$r['id']." ORDER BY date DESC LIMIT {$settings['knowledgebase_articlesundercat']}");
                while($ka = $db->fetch_array($aq)){
                    $ka['url'] = getUrl('knowledgebase',$r['id'],array('article', $ka['id'], strtourl($ka['title'])));
                    $r['article'][] = $ka;
                }
            }
            $kb_category[] = $r;
        }

    }
}