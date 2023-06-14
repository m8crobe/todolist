<?php

$server_name = "localhost";
$user = "root";
$password = "";
$port = "3306";
$database = "todolist";
// MySQL 데이터베이스 연결
//$connect = new mysqli($host, $username, $password, $database);

$connect = mysqli_connect($server_name, $user, $password, $database);
mysqli_select_db($connect, $database) or die ("db 선택 실패");



// select
function db_fetch_arr($qry){
    global $connect;
    $result = mysqli_query($connect, $qry);
    $rows = array();
    while ($row = mysqli_fetch_array($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// 단일 select
function db_fetch_row($qry){
    global $connect;
    $result = mysqli_query($connect, $qry);
    $row = mysqli_fetch_assoc($result);
    return $row;
}

// insert
function db_insert($table, $arr){
    global $connect;
    $columns = implode(", ", array_keys($arr));
    $values = implode("', '", array_values($arr));
    $qry = "INSERT INTO $table ($columns) VALUES ('$values')";
    echo "<br>qry=".$qry;
    return mysqli_query($connect, $qry);
}

// delete
function db_delete($table, $del_arr){
    global $connect;
    $conditions = array();
    foreach ($del_arr as $column => $value) {
        $conditions[] = "$column = '$value'";
    }
    $where_clause = implode(" AND ", $conditions);

    $qry = "DELETE FROM $table WHERE $where_clause";
    echo "<br>qry=".$qry;
    return mysqli_query($connect, $qry);
}

// update
function db_update($table, $arr_data, $pk_arr){
    global $connect;
    
    $set_values = array();
    foreach ($arr_data as $column => $value) {
        $set_values[] = "$column = '$value'";
    }
    $set_clause = implode(", ", $set_values);

    $conditions = array();
    foreach ($pk_arr as $column => $value) {
        $conditions[] = "$column = '$value'";
    }
    $where_clause = implode(" AND ", $conditions);

    $qry = "UPDATE $table SET $set_clause WHERE $where_clause";
    echo "<br>qry=".$qry;

    return mysqli_query($connect, $qry);
}



?>