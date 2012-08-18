<?php 
/**
 * Entry class
 * 
 * PHP version 5.3.10
 * 
 * @category PHP
 * @package  Bumrang
 * @author   Pierre Rudloff <rudloff@strasweb.fr>
 * @license  New BSD License http://opensource.org/licenses/BSD-3-Clause
 * @link     http://svn.strasweb.fr
 * */
 
 /**
  * Class to manage entries
  * 
  * @category PHP
 * @package  Bumrang
 * @author   Pierre Rudloff <rudloff@strasweb.fr>
 * @license  New BSD License http://opensource.org/licenses/BSD-3-Clause
 * @link     http://svn.strasweb.fr
  * */
class Entry
{
    
    /**
     * Entry constructor
     * 
     * @param int $num Serial number
     * 
     * @return Entry
     * */
    function __construct($num)
    {
        global $config;
        global $sql;
        $query=file_get_contents("sql/get.sql");
        if ($query) {
            $query = $sql->prepare($query);
            $query->bindValue(':num', $num, PDO::PARAM_INT);
            $query->execute();    
            $result=$query->fetch(PDO::FETCH_OBJ);
            $this->num=$result->num;
            $this->id=$result->id;
            $this->name=$result->name;
            $this->firstname=$result->firstname;
            $this->email=$result->email;
            $this->extend=$result->extend;
            for ($i=1;$i<=4;$i++) {
                $this->{"other".$i}=$result->{"other".$i};
            }
            $this->date1=$result->date1;
            $this->date2=$result->date2;
            
            return $this;
        } else {
            return print_r($query->errorInfo());
        }
        
    }
    
    /**
     * Get all entries
     * 
     * @return object
     * */
    function getEntries()
    {
        global $config;
        global $sql;
        $query=file_get_contents("sql/getAll.sql");
        $query = $sql->query($query);
        if ($query) {
            $result=$query->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } else {
            return print_r($query->errorInfo());
        }
    }
    
    /**
     * Add an entry
     * 
     * @param Entry $entry Entry
     * 
     * @return bool
     * */
    function addEntry($entry)
    {
        global $config;
        global $sql;
        $query=file_get_contents("sql/add.sql");
        
        $query = $sql->prepare($query, array(PDO::PARAM_NULL));
        $param=array(
            $entry->id, $entry->name, $entry->firstname, $entry->email,
            $entry->date1, $entry->date2, $entry->other1, $entry->other2,
            $entry->other3, $entry->other4
        );
        $result=$query->execute($param);
        if ($result) {
            return true;
        } else {
            print_r($query->errorInfo());
        }
    }
    
    /**
     * Delete an entry
     * 
     * @return bool
     * */
    function deleteEntry()
    {
        global $config;
        global $sql;
        $query=file_get_contents("sql/delete.sql");
        $query = $sql->prepare($query);
        
        $query->bindValue(':num', $this->num, PDO::PARAM_INT);
        $result=$query->execute();
        if ($result) {
            return true;
        } else {
            print_r($query->errorInfo());
        }
    }
    
    /**
     * Return a book
     * 
     * @return bool
     * */
    function returnEntry()
    {
        global $config;
        global $sql;
        $query=file_get_contents("sql/return.sql");
        $query = $sql->prepare($query);
        
        $date2=$config->today->format("Y-m-d");
        
        $query->bindValue(':date2', $date2);
        $query->bindValue(':num', $this->num, PDO::PARAM_INT);
        $result=$query->execute();
        if ($result) {
            return true;
        } else {
            print_r($sql->errorInfo());
        }
    }
    
    /**
     * Update an entry
     * 
     * @param Entry $entry Entry
     * 
     * @return bool
     * */
    function updateEntry($entry)
    {
        global $config;
        global $sql;
        $query=file_get_contents("sql/update.sql");
        
        $query = $sql->prepare($query, array(PDO::PARAM_NULL));
        $param=array(
            $entry->id, $entry->name, $entry->firstname, $entry->email,
            $entry->other1, $entry->other2, $entry->other3,
            $entry->other4, $entry->date1, $entry->num
        );
        $result=$query->execute($param);
        if ($result) {
            return true;
        } else {
            print_r($sql->errorInfo());
        }
    }
    
    /**
     * Extend the duration of an entry
     * 
     * @return bool
     * */
    function extendEntry()
    {
        global $config;
        global $sql;
        $query=file_get_contents("sql/extend.sql");
        
        $query = $sql->prepare($query, array(PDO::PARAM_NULL));
        $query->bindValue(':num', $this->num, PDO::PARAM_INT);
        $query->bindValue(':extend', $this->extend+1, PDO::PARAM_INT);
        
        $result=$query->execute();
        if ($result) {
            return true;
        } else {
            print_r($query->errorInfo());
        }
    }
    
    
}


?>
