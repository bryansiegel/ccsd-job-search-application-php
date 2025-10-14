<?php
/**
 * User: tmiller
 * Date: 8/19/15
 * Time: 8:06 AM
 */

//connect to DB
mysql_connect('heraclitus.ccsd.net', 'httpd', 'H!2m;Leg+z%ZP7KC');
mysql_select_db("sexeddb");

$line = "";
$grades = "";
$courses = "";

echo '"ITEM NO","GRADES","COURSES","TITLE","DESCRIPTION","ISBN","COPYRIGHT","GENDER","COMMENTS","STATUS","RETIRED DATE","SAC STATUS","SAC DATE","TRUSTEE STATUS","TRUSTEE DATE"';

$query = "SELECT
          pk,item_no, title, description, isbn, copyright,
          gender, comments, status, retired_date, sac_status, sac_date,
          trustee_status, trustee_date
          FROM items
          ORDER BY title ASC";

$result = mysql_query($query);


while($row = mysql_fetch_array($result)) {
    $line .= "<br>\"$row[item_no]\",";

    //get grades for the item
    $grade_query = "SELECT grade
                    FROM item_gradelevels
                    WHERE item_pk='$row[pk]'";

    $grade_result = mysql_query($grade_query);

    while($row_grade = mysql_fetch_array($grade_result)) {
        $grades .= "$row_grade[grade]-";
    }
    $grades = rtrim($grades, "-");


    //append grade to line
    $line .= "\"$grades\", ";
    $grades = "";

    //get coureses for the item
    $course_query = "SELECT list_courses.course
                     FROM list_courses, item_courses
                     WHERE item_courses.item_pk='$row[pk]' && item_courses.course_pk=list_courses.pk";

    $course_result = mysql_query($course_query);

    while($row_course = mysql_fetch_array($course_result))  {
        $courses .= "$row_course[course]: ";
    }
    $courses = rtrim($courses, ": ");

    //append couses to line
    $line .= "\"$courses\",";
    $courses = "";

    $title = stripslashes($row['title']);
    $description = stripslashes($row['description']);
    //finish the line with items pulled from original query
    $line .= "\"$title\",\"$description\",\"$row[isbn]\",\"$row[copyright]\",\"$row[gender]\",\"$row[comments]\",\"$row[status]\",\"$row[retired_date]\",\"$row[sac_status]\",\"$row[sac_date]\",\"$row[trusetee_status]\",\"$row[trustee_date]\"\n";
}

echo $line;
?>