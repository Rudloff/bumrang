<?php
/**
 * HTMl head
 * 
 * PHP version 5.3.10
 * 
 * @category PHP
 * @package  Bumrang
 * @author   Pierre Rudloff <rudloff@strasweb.fr>
 * @license  New BSD License http://opensource.org/licenses/BSD-3-Clause
 * @link     http://svn.strasweb.fr
 * */
$dom->html->addElement("head");
$dom->html->head->addElement("meta", null, array("charset"=>"UTF-8"));
$dom->html->head->addElement("title", $bumrang);
$dom->html->head->addElement(
    "link", null, array("rel"=>"stylesheet", "href"=>"style.css")
);
$dom->html->head->addElement(
    "link", null,
    array(
        "rel"=>"gettext", "href"=>"locale/fr/LC_MESSAGES/messages.po",
        "lang"=>"fr"
    )
);
$dom->html->head->addElement("script", "", array("src"=>"prototype.js"));
$dom->html->head->addElement("script", "", array("src"=>"gettext.js"));
$dom->html->head->addElement("script", "", array("src"=>"script.js"));
$dom->html->head->addElement(
    "meta", null, array("name"=>"generator", "content"=>$bumrang." ".$config->ver)
);

?>
