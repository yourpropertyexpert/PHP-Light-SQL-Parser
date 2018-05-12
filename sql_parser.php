<?php
/**
 * Get SQL Query method
 * @author Marco Cesarato <cesarato.developer@gmail.com>
 * @param $query
 * @return string
 */
function sql_query_method($query){
    $methods = array('SELECT','INSERT','UPDATE','DELETE','REPLACE','RENAME','SHOW','SET','DROP','CREATE INDEX','CREATE TABLE','EXPLAIN','DESCRIBE');
    $query = preg_replace('#\/\*[\s\S]*?\*\/#','', $query);
    $query = preg_replace(';(?:(?<=["\'];)|(?=["\']))', '', $query);
    $query = explode(';', $query);
    foreach($query as $_q){
        foreach($methods as $method) {
            $_method = str_replace(' ', '[\s]+', $method);
            if(preg_match('/^[\s]*'.$_method.'[\s]+/i', $_q)){
                return '$method';
            }
        }
    }
    return 'UNKOWN';
}
/**
 * Get SQL Query First Table
 * @author Marco Cesarato <cesarato.developer@gmail.com>
 * @param $query
 * @return boolean|string
 */
function sql_query_table($query){
    $table = '';
    $query = preg_replace('#\/\*[\S\s]*?\*\/#','', $query);
    $patterns = array(
        '#[\S\s]+[\s]+FROM[\s]+([\w]+)[\s]*[\S\s]*#i',
        '#[\S\s]*UPDATE[\s]+([\w]+)[\s]*[\S\s]*#i',
        '#[\S\s]*INSERT[\s]+INTO[\s]+([\w]+)[\s]*[\S\s]*#i',
        '#[\S\s]*DELETE[\s]+([\w]+)[\s]*[\S\s]*#i'
    );
    foreach($patterns as $pattern){
        $table = preg_replace($pattern,'$1', $query);
        if(!empty(trim($table)) || $table != $query) break;
    }
    return trim($table);
}