<?php
/**
 * @var $this CI_Model
 */
$site_title = lang('knowledgebase');
if(!isset($cat_name)){
    include 'kb_search_box.php';
}
include 'header.php';
if(isset($cat_name)){
    ?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url('kb');?>"><?php echo lang('knowledgebase');?></a></li>
        <?php
        if($parents = $this->kb->categoryParents($cat_parent)){
            foreach ($parents as $id => $name){
                echo '<li class="breadcrumb-item"><a href="'.site_url('kb/cat/'.$id.'/'.url_title($name)).'">'.$name.'</a></li>';
            }
        }
        ?>
        <li class="breadcrumb-item active"><?php echo $cat_name;?></li>
    </ol>
    <?php
}
?>
    <h2 class="title_light mb-4"><?php echo isset($cat_name) ? $cat_name : lang('knowledgebase');?></h2>

<?php if($cats = $this->kb->getCategories($cat_id)){ ?>
    <div class="row">
        <?php
        $columns = 12/$this->settings->get('knowledgebase_columns');
        foreach ($cats as $cat) {
            $total_articles = $this->kb->countArticles($cat->id);
            if($total_articles > 0){
                ?>
                <div class="col-md-<?php echo $columns; ?> mb-4">
                    <h3 class="title_light mb-3"><a href="<?php echo site_url('kb/cat/' . $cat->id . '/' . url_title($cat->name)); ?>"><?php echo $cat->name; ?></a> <small class="text-muted float-right">(<?php echo $total_articles;?>)</small></h3>
                    <hr>
                    <ul class="list-unstyled">
                    <?php
                    foreach ($this->kb->categoryArticles($cat->id, true) as $article){
                        ?>
                        <li class="mb-3"><small><i class="fa fa-file-o text-muted"></i></small> <a href="<?php echo site_url('kb/article/'.$article->id.'/'.url_title($article->title));?>"><?php echo $article->title;?></a></li>
                        <?php
                    }
                    ?>
                    </ul>
                </div>
                <?php
            }
        }
        ?>
    </div>
<?php }

if($articles = $this->kb->getArticles($cat_id)){
    foreach ($articles as $article){
        echo '<div class="mb-5">';
        echo '<h3 class="mb-3"><a href="'.site_url('kb/article/'.$article->id.'/'.url_title($article->title)).'">'.$article->title.'</a></h3>';
        echo $article->content;
        echo '</div>';
    }
}

if($this->settings->get('knowledgebase_mostpopular') == 'yes' || $this->settings->get('knowledgebase_newest') == 'yes'){
    $cols = $this->settings->get('knowledgebase_mostpopular') == 'yes' && $this->settings->get('knowledgebase_newest') == 'yes' ? 6 : 12;
    ?>
    <div class="row">
        <div class="col-md-<?php echo $cols;?> mb-3">
            <h4 class="mb-3 title_light"><?php echo lang('most_popular_articles');?></h4>
            <?php
            if(!$list = $this->kb->getPopular()){
                echo lang('no_articles');
            }else{
                echo '<ul class="list-group">';
                foreach ($list as $item){
                    echo '<li class="list-group-item text-muted"><small><i class="fa fa-file-o text-muted"></i></small> <a href="'.site_url('kb/article/'.$item->id.'/'.url_title($item->title)).'">'.$item->title.'</a></li>';
                }
                echo '</ul>';
            }
            ?>
        </div>
        <div class="col-md-<?php echo $cols;?> mb-3">
            <h4 class="mb-3 title_light"><?php echo lang('newest_articles');?></h4>
            <?php
            if(!$list = $this->kb->getPopular()){
                echo lang('no_articles');
            }else{
                echo '<ul class="list-group">';
                foreach ($list as $item){
                    echo '<li class="list-group-item"><small><i class="fa fa-file-o text-muted"></i></small> <a href="'.site_url('kb/article/'.$item->id.'/'.url_title($item->title)).'">'.$item->title.'</a></li>';
                }
                echo '</ul>';
            }
            ?>
        </div>
    </div>
    <?php
}
include 'footer.php';