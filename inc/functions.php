<?php
/**
 * Useful functions
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
 * Get the difference between two dates
 * 
 * @param Date $start First date
 * @param Date $end   Second date
 * 
 * @return array
 * */
function Get_Time_difference($start, $end)
{
    $uts['start']      =    strtotime($start);
    $uts['end']        =    strtotime($end);
    if ($uts['start']!==-1 && $uts['end']!==-1) {
        if ($uts['end'] >= $uts['start']) {
            $diff    =    $uts['end'] - $uts['start'];
            if ($days=intval((floor($diff/86400)))) {
                $diff = $diff % 86400;
            }
            if ($hours=intval((floor($diff/3600)))) {
                $diff = $diff % 3600;
            }
            if ($minutes=intval((floor($diff/60)))) {
                $diff = $diff % 60;
            }
            $diff    =    intval($diff);            
            return array(
                'days'=>$days, 'hours'=>$hours,
                'minutes'=>$minutes, 'seconds'=>$diff
            ) ;
        } else {
            trigger_error(
                "Ending date/time is earlier than the start date/time",
                E_USER_WARNING
            );
        }
    } else {
        trigger_error("Invalid date/time data detected", E_USER_WARNING);
    }
    return(false);
}

/**
 * Create <table> headers
 * 
 * @param DOMElement $table Table
 * 
 * @return  void
 * */
function createTableHeaders($table)
{
    global $dom;
    global $config;
    $table->tr->addElement("th", _("ID"));
    $table->tr->addElement("th", _("Name"));
    $table->tr->addElement("th", _("First Name"));
    $table->tr->addElement("th", _("E-mail"));
    for ($i=1;$i<=4;$i++) {
        if (isset($config->{"other".$i})) {
            $table->tr->addElement("th", $config->{"other".$i});
        }
    }	
}

?>
