<?php
/**
 * @package DeskIgniter
 * @author: PeruCoder Dev Team
 * @Copyright (c) 2017, PeruCoder Dev Team - All rights reserved
 * @link http://deskigniter.com
 */

function lang_replace($line, $search, $replace=''){
    if(!is_array($search)){
        $search = [$search => $replace];
    }
    return str_replace(array_keys($search), array_values($search), lang($line));
}