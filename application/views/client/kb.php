<?php
/**
 * @var $this CI_Model
 */
$site_title = lang('knowledgebase');
include 'kb_search_box.php';
include 'header.php';
?>
<h2 class="title_light"><?php echo isset($cat_title) ? $cat_title : lang('knowledgebase');?></h2>
<hr>

<?php if($cats = $this->kb->getCategories($cat_id)):?>
    <div class="row">
        <?php
        $columns = 12/$this->settings->get('knowledgebase_columns');
        foreach ($cats as $cat):
        ?>
        <div class="col-md-<?php echo $columns;?>">
            <h3 class="title_light"><a href="<?php echo site_url('kb/cat/'.$cat->id.'/'.url_title($cat->name));?>"><?php echo $cat->name;?></a></h3>
        </div>
        <?php endforeach;?>
    </div>
    <?php endif;?>


        	<table width="100%" cellpadding="5" cellspacing="5">
            {% set columnspercent = (100/settings.knowledgebase_columns)|round(2) %}
            {% set n = 1 %}
            {% set totalart = 0 %}
            {% for kb_cat in kb_category %}{% if kb_cat.total_articles != 0 %}
               {% set totalart = 1 %}
               {% set result = n%settings.knowledgebase_columns %}
               {% if result == 1 %}<tr>{% endif %}
				<td width="{{ columnspercent }}%" valign="top"><div class="knowledgebasecategorytitle"><a href="{{ kb_cat.url }}">{{ kb_cat.name }}</a></div>
                {% for article in kb_cat.article %}
                <div class="knowledgebasearticlelist"><a href="{{ article.url }}">{{ article.title }}</a></div>
                {% endfor %}
                {% if kb_cat.total_articles > settings.knowledgebase_articlesundercat %}
                <div><a href="{{ kb_cat.url }}">&raquo; {{ LANG.MORE_TOPICS }}</a></div>
                {% endif %}
                </td>
               {% if result == 0 %}</tr>{% endif %}
               {% set n = n+1 %}
            {% endif %}{% endfor %}
            </table>
			{% if totalart != 0 %}<div style="margin-bottom:20px"></div>{% endif %}
            
            {% for article in articles %}
				<div class="knowledgebasearticlelisttitle"><a href="{{ article.url }}">{{ article.title }}</a></div>
				<div style="margin-bottom:20px;">{{ article.content|raw }}</div>
			{% endfor %}
            
            <table width="100%">
            	<tr>
                	{% if settings.knowledgebase_mostpopular == 'yes' %}
                	<td width="50%" valign="top"><div class="knowledgebasepopulartitle">{{ LANG.MOST_POPULAR_ARTICLES }}</div></td>
					{% endif %}
					{% if settings.knowledgebase_newest == 'yes' %}
                	<td width="50%" valign="top"><div class="knowledgebasepopulartitle">{{ LANG.NEWEST_ARTICLES }}</div></td>
					{% endif %}
                </tr>
                <tr>
                {% if settings.knowledgebase_mostpopular == 'yes' %}
                	<td valign="top">
					{% for kb in kb_popular %}
					<div class="knowledgebasearticlelist"><a href="{{ kb.url }}">{{ kb.title }}</a></div>
					{% endfor %}
					</td>
				{% endif %}
				{% if settings.knowledgebase_newest == 'yes' %}
                	<td valign="top">
					{% for kb in kb_newest %}
					<div class="knowledgebasearticlelist"><a href="{{ kb.url }}">{{ kb.title }}</a></div>
					{% endfor %}
					</td>
				{% endif %}
                </tr>
            </table>
<?php
include 'footer.php';