<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        echo '<table border=1>';
        foreach ($data as $row_key => $row_value) {
            echo '<tr>';
            foreach ($row_value as $col_key => $col_value) {
                echo '<td>'.$col_value.'</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
        ?>
        <br/>Time : {MVC_SYSTEM_TIMER} <br/>
    </body>
</html>
