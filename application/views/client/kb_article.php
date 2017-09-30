<?php
/**
 * @var $this CI_Model
 */
include 'header.php';
?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url('kb');?>"><?php echo lang('knowledgebase');?></a></li>
        <?php
        if($parents = $this->kb->categoryParents($article->cat_id)){
            foreach ($parents as $id => $name){
                echo '<li class="breadcrumb-item"><a href="'.site_url('kb/cat/'.$id.'/'.url_title($name)).'">'.$name.'</a></li>';
            }
        }
        ?>
        <li class="breadcrumb-item active"><?php echo $cat_name;?></li>
    </ol>

{% block title %}{{ LANG.KNOWLEDGEBASE }} > {{ article.title }}{% endblock %}
{% block content %}
{% include 'knowledgebase_searchbox.html' %}
<div class="title">
	{{ LANG.KNOWLEDGEBASE }} {% if cat_id != 0 %}: {{ cat_title|raw }}{% endif %}
</div>
<div class="knowledgebasearticletitle">{{ article.title }}</div>
<div class="knowledgebasearticletitledescr">{{ LANG.POSTED_BY_ON|replace({'%author%':article.author, '%date%':displayDate(article.date)}) }}</div>
<div>{{ article.content|raw }}</div>

{% if attachments|is_array %}
<div class="knowledgebasearticleattachment">{{ LANG.ATTACHMENTS }}</div>
    {% for attachment in attachments %}
    <div><span class="knowledgebaseattachmenticon"></span> <a href="{{ attachment_url }}{{ attachment.id }}" target="_blank">{{ attachment.name }} ({{ attachment.filesize }})</a></div>
        
    {% endfor %}
{% endif %}
<?php
include 'footer.php';