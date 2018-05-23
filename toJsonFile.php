<?php
/**
 * for converting database table to JSON file
 * for Franz's search
 */

    //open connection to mysql db
    $connection = mysqli_connect("localhost","root","","projectsend") or die("Error " . mysqli_error($connection));

    //fetch table rows from mysql db
    $sql = "select 
            c.name as data_source,
            f.filename as title,
            f.uploader as author,
            f.timestamp as date,
            f.description as description,
            f.url as link
            from tbl_files f
            inner join tbl_categories_relations r
            on f.id=r.file_id
            inner join tbl_categories c
            on r.cat_id=c.id";
    $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));
    

    //create an array
    $emparray = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray[] = $row;
    }
    //echo json_encode($emparray);

    //save to file
    $fp = fopen('results.json', 'w');
    fwrite($fp, json_encode($emparray));
    fclose($fp);

    //close the db connection
    mysqli_close($connection);
?>


<?php
//let user save a copy to their designated location
$file = 'results.json';

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}
?>


<?php
//go back to prev
    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

?>