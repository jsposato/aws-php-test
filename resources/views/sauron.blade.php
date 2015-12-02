<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Sauron</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- for datatables styling -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <img align="left" src="img/sauron.png" alt="Sauron, the all seeing eye!" height="97" width="90">
        </div>
        <div class="col-md-4">
            <h1 align="center">Sauron</h1>
        </div>
        <div class="col-md-4">
            <img align="right" src="img/sauron.png" alt="Sauron, the all seeing eye!" height="97" width="90">
        </div>
    </div>
    <hr>
    <div class="row col-md-12">
        <?php

        $tableName = 'sauron';

        $dynamo = App::make('aws')->createClient('DynamoDb');

        $request = [
                'TableName' => $tableName,
        ];

        $results = $dynamo->scan($request);
        asort($results['Items']);

        $tableStart = "<table id=\"main\" class=\"table table-condensed table-striped table-hover table-bordered\">\n";
        $tableEnd = "</tbody></table>";

        $header = "<thead><tr>
            <th>Project Id</th>
            <th>Project Name</th>
            <th>Total Story Points</th>
            <th># Stories</th>
            <th># Bugs</th>
            <th># Misses</th>
            <th># Improvements</th>
            <th># Unknown</th>
            <th># Open Story Points</th>
            <th># In Progress Story Points</th>
            <th># QA Review Story Points</th>
            <th># Showcase Story Points</th>
            <th># Closed Story Points</th>
           </tr></thead><tbody>\n";

        echo $tableStart;
        echo $header;

        foreach ($results['Items'] as $key => $value) {
            if($value['project']['S'] == 'Project') {
                continue;
            }
            echo "<tr>";
            echo '<td>' . $value['Project_Id']['S'] . "</td>";
            echo '<td>' . str_replace('"', "", $value['project']['S']) . "</td>";
            echo '<td>' . $value['Total_Story_Points']['S'] . "</td>";
            echo '<td>' . $value['Story_Count']['S'] . "</td>";
            echo '<td>' . $value['Bug_Count']['S'] . "</td>";
            echo '<td>' . $value['Miss_Count']['S'] . "</td>";
            echo '<td>' . $value['Improvement_Count']['S'] . "</td>";
            echo '<td>' . $value['Unknown_Count']['S'] . "</td>";
            echo '<td>' . $value['Total_Open_Story_Points']['S'] . "</td>";
            echo '<td>' . $value['Total_In_Progress_Story_Points']['S'] . "</td>";
            echo '<td>' . $value['Total_QA_Review_Story_Points']['S'] . "</td>";
            echo '<td>' . $value['Total_Showcase_Story_Points']['S'] . "</td>";
            echo '<td>' . $value['Total_Closed_Story_Points']['S'] . "</td>";
            echo "</tr>\n";
        }

        echo $tableEnd;
        ?>

                <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js"></script>

        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>

        <script language="JavaScript">
            $(document).ready(function() {
                $('#main').DataTable({
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    "stateSave": true,
                    "iDisplayLength": 50
                });
            } );
        </script>
    </div>
</div>

</body>
</html>