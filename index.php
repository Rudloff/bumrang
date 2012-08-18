<?php
/**
 * Index file
 * 
 * PHP version 5.3.10
 * 
 * @category PHP
 * @package  Bumrang
 * @author   Pierre Rudloff <rudloff@strasweb.fr>
 * @license  New BSD License http://opensource.org/licenses/BSD-3-Clause
 * @link     http://svn.strasweb.fr
 * */
header("Content-type: text/html;charset=UTF-8");
require "inc/sql_connect.php";
require "inc/functions.php";
require "inc/vars.php";
require "inc/localization.php";
require_once "classes/Entry.php";
require_once "classes/DOMElement.php";


if (isset($_POST["delete"])) {
    $deletedEntry= new Entry($_POST["num"]);
    $deletedEntry->deleteEntry();
    
} elseif (isset($_POST["extend"])) {
    $extendEntry= new Entry($_POST["num"]);
    $extendEntry->extendEntry();
    
} elseif (isset($_POST["return"])) {
    $returnedEntry= new Entry($_POST["num"]);
    
    $returnedEntry->returnEntry();
    
} elseif (isset($_POST["update"])) {
    $updatedEntry->num=$_POST["num"];
    $updatedEntry->id=isset($_POST["id"])?$_POST["id"]:"";
    $updatedEntry->name=isset($_POST["name"])?$_POST["name"]:"";
    $updatedEntry->firstname=isset($_POST["firstname"])?$_POST["firstname"]:"";
    $updatedEntry->email=isset($_POST["email"])?$_POST["email"]:"";
    $updatedEntry->other1=isset($_POST["other1"])?$_POST["other1"]:"";
    $updatedEntry->other2=isset($_POST["other2"])?$_POST["other2"]:"";
    $updatedEntry->other3=isset($_POST["other3"])?$_POST["other3"]:"";
    $updatedEntry->other4=isset($_POST["other4"])?$_POST["other4"]:"";
    $updatedEntry->date1=isset($_POST["date1"])?$_POST["date1"]:"";
    Entry::updateEntry($updatedEntry);
    
} elseif (isset($_POST["add"])) {
    $newEntry->id=isset($_POST["id"])?$_POST["id"]:"";
    $newEntry->name=isset($_POST["name"])?$_POST["name"]:"";
    $newEntry->firstname=isset($_POST["firstname"])?$_POST["firstname"]:"";
    $newEntry->email=isset($_POST["email"])?$_POST["email"]:"";
    $newEntry->other1=isset($_POST["other1"])?$_POST["other1"]:"";
    $newEntry->other2=isset($_POST["other2"])?$_POST["other2"]:"";
    $newEntry->other3=isset($_POST["other3"])?$_POST["other3"]:"";
    $newEntry->other4=isset($_POST["other4"])?$_POST["other4"]:"";
    $newEntry->date1=$config->today->format("Y-m-d");
    $newEntry->date2="";
    
    Entry::addEntry($newEntry);
}





$doctype=DOMImplementation::createDocumentType('html');
$dom=DOMImplementation::createDocument(null, "html", $doctype);
$dom->registerNodeClass('DOMElement', 'NewDOMElement');
$dom->html=$dom->documentElement;
$dom->html->setAttribute("xmlns", "http://www.w3.org/1999/xhtml");
require "inc/head.php";
$dom->html->addElement("body");
$dom->html->body->addElement("table", null, array("id"=>"mainTable"));
$dom->html->body->table->addElement("tr");
$dom->html->body->table->tr->addElement("th");
createTableHeaders($dom->html->body->table);
$dom->html->body->table->tr->addElement("th", _("Borrowed"));
$dom->html->body->table->tr->th->addElement("br");
$dom->html->body->table->tr->th->addElement("small", "("._("YYYY-MM-DD").")");
$dom->html->body->table->tr->addElement("th", _("Due"));
$dom->html->body->table->tr->th->addElement("br");
$dom->html->body->table->tr->th->addElement("small", "("._("YYYY-MM-DD").")");
$dom->html->body->table->tr->addElement("th");

$dom->html->body->addElement(
    "form", null, array("method"=>"post", "action"=>"index.php")
);
$dom->html->body->form->addElement("table");
$dom->html->body->form->table->addElement("caption", _("Add entry"));
$dom->html->body->form->table->addElement("tr");
createTableHeaders($dom->html->body->form->table);
$dom->html->body->form->table->tr->addElement("th");
$dom->html->body->form->table->addElement("tr", null, array("id"=>"addForm"));
$dom->html->body->form->table->tr->addElement("td");
$dom->html->body->form->table->tr->td->addElement(
    "input", null, array("placeholder"=>_("ID"), "name"=> "id")
);
$dom->html->body->form->table->tr->td->addElement(
    "input", null, array("type"=>"hidden", "name"=> "add", "value"=>"true")
);
$dom->html->body->form->table->tr->addElement("td");
$dom->html->body->form->table->tr->td->addElement(
    "input", null, array("placeholder"=>_("Name"), "name"=> "name")
);
$dom->html->body->form->table->tr->addElement("td");
$dom->html->body->form->table->tr->td->addElement(
    "input", null, array("placeholder"=>_("First Name"), "name"=> "firstname")
);
$dom->html->body->form->table->tr->addElement("td");
$dom->html->body->form->table->tr->td->addElement(
    "input", null, array("placeholder"=>_("E-mail"), "name"=> "email")
);
for ($i=1;$i<=4;$i++) {
    if (isset($config->{"other".$i})) {
        $dom->html->body->form->table->tr->addElement("td");        
        $dom->html->body->form->table->tr->td->addElement(
            "input", null,
            array("placeholder"=>$config->{"other".$i}, "name"=> "other".$i)
        );
    }
}
$dom->html->body->form->table->tr->addElement("td");
$dom->html->body->form->table->tr->td->addElement(
    "input", null, array("type"=>"submit", "value"=> "+", "title"=> _("Add"))
);




$dom->html->body->addElement(
    "table", null, array("id"=>"otherTable")
);
$dom->html->body->table->addElement(
    "caption", _("Returned elements"), array("id"=>"hideReturned", "class"=>"show")
);
$dom->html->body->table->addElement("tr");
$dom->html->body->table->tr->addElement("th");
createTableHeaders($dom->html->body->table);
$dom->html->body->table->tr->addElement("th", _("Borrowed"));
$dom->html->body->table->tr->th->addElement("br");
$dom->html->body->table->tr->th->addElement("small", "("._("YYYY-MM-DD").")");
$dom->html->body->table->tr->addElement("th", _("Returned"));
$dom->html->body->table->tr->th->addElement("br");
$dom->html->body->table->tr->th->addElement("small", "("._("YYYY-MM-DD").")");

$entries=Entry::getEntries();

foreach ($entries as $entry) {
    $date_diff=get_time_difference($entry->date1, $config->today->format("Y-m-d"));
    if ($entry->date2=="0000-00-00") {
        $table=$dom->getElementById("mainTable");
        
        $entry->dueDelay=$config->dueDelay*($entry->extend+1);
        $entry->dueDate = strtotime(
            "+".$entry->dueDelay." days", strtotime($entry->date1)
        );
        $entry->dueDate=date("Y-m-d", $entry->dueDate);
        if ($date_diff["days"]>$entry->dueDelay) {
            $class="late";
        } else {
            $class="";
        }
        $entry->returned=$entry->dueDate;
        
        
    } else {
        $class="";
        $table=$dom->getElementById("otherTable");
        $entry->returned=$entry->date2;
        
    }
    $table->addElement("tr", null, array("class"=>$class));
    $table->tr->addElement("td");
    $table->tr->td->addElement(
        "form", null, array("action"=>"index.php", "method"=>"post")
    );
    $table->tr->td->form->addElement(
        "input", null, array("name"=>"delete", "value"=>"true", "type"=>"hidden")
    );
    $table->tr->td->form->addElement(
        "input", null,
        array("name"=>"num", "value"=>$entry->num, "type"=>"hidden")
    );
    $table->tr->td->form->addElement(
        "input", null,
        array("value"=>_("Delete"), "type"=>"submit", "class"=>"deleteButton")
    );
    $table->tr->addElement("td", $entry->id);
    $table->tr->addElement("td", $entry->name);
    $table->tr->addElement("td", $entry->firstname);
    $table->tr->addElement("td", $entry->email);
    for ($i=1;$i<=4;$i++) {
        if (isset($config->{"other".$i})) {
            $table->tr->addElement("td", $entry->{"other".$i});
        }
    }
    $table->tr->addElement("td", $entry->date1, array("class"=>"date1"));
    $table->tr->addElement("td", $entry->returned, array("class"=>"date2"));
    
    
    if ($entry->date2=="0000-00-00") {
        $table->tr->addElement("td");
        $table->tr->td->addElement(
            "form", null, array("action"=>"index.php", "method"=>"post")
        );
        $table->tr->td->form->addElement(
            "input", null,
            array("name"=>"return", "value"=>"true", "type"=>"hidden")
        );
        $table->tr->td->form->addElement(
            "input", null,
            array("name"=>"num", "value"=>$entry->num, "type"=>"hidden")
        );
        $table->tr->td->form->addElement(
            "input", null, array("value"=>_("Returned"), "type"=>"submit")
        );
        
        $table->tr->td->addElement(
            "form", null, array("action"=>"index.php", "method"=>"post")
        );
        $table->tr->td->form->addElement(
            "input", null,
            array("name"=>"extend", "value"=>"true", "type"=>"hidden")
        );
        $table->tr->td->form->addElement(
            "input", null,
            array("name"=>"extendNum", "value"=>$entry->extend,
            "type"=>"hidden", "class"=>"extendNum")
        );
        $table->tr->td->form->addElement(
            "input", null,
            array("name"=>"num", "value"=>$entry->num, "type"=>"hidden")
        );
        $table->tr->td->form->addElement(
            "input", null,
            array("value"=>_("Extend"),
            "type"=>"submit", "class"=>"extendButton")
        );
        
    }
        
}

print($dom->saveHTML());

?>
