
<?php
include "get_statistics.php";


$topic = "artificial intelligence";
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET["topic"])) {
        $topic = $_GET["topic"];
    }
}


$info = get_info($topic);

//print_r($info);
?>


<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Hot Topics</title>

        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/1-col-portfolio.css" rel="stylesheet">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    </head>

    <body>

        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container">
                <a class="navbar-brand" href="#">Hot Topics</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">
                                <span class="sr-only"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="container">

            <!-- Page Heading -->
            <h1 class="my-4">Hot Topics
                <small><i>... discovering trends</i></small>
            </h1>

            <!-- Project One -->
            <div class="row">
                <div class="col-md-7">
                    <script type="text/javascript">
                        google.charts.load("current", {packages: ["corechart"]});
                        google.charts.setOnLoadCallback(drawChart);
                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                                ["Year", "Downloads", {role: "style"}],
                                ["2015", <?php echo $info["metrics"]["downloads2015"]; ?>, "#b87333"],
                                ["2016", <?php echo $info["metrics"]["downloads2016"]; ?>, "silver"],
                                ["2017", <?php echo $info["metrics"]["downloads2017"]; ?>, "gold"]
                            ]);

                            var view = new google.visualization.DataView(data);
                            view.setColumns([0, 1,
                                {calc: "stringify",
                                    sourceColumn: 1,
                                    type: "string",
                                    role: "annotation"},
                                2]);

                            var options = {
                                title: "Number of downloads per year",
                                width: 700,
                                height: 300,
                                bar: {groupWidth: "95%"},
                                legend: {position: "none"},
                            };
                            var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
                            chart.draw(view, options);
                        }
                    </script>
                    <div id="barchart_values" style="width: 700px; height: 300px;"></div>
                </div>
                <div class="col-md-5">
                    <h3><?php echo $info['topic']; ?></h3>
                    <p><?php echo "Altmetrics: " . $info["metrics"]["altmetric"]; ?></br> <?php echo "Citations: " . $info["metrics"]["times_cited"]; ?></br> <?php echo "Downloads: " . $info["metrics"]["downloads"]; ?></p>
                    <!--          <a class="btn btn-primary" href="#">View Project</a>-->
                </div>
            </div>
            <!-- /.row -->

            <hr>

            <!-- Project Two -->
            <div class="row">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Topic</th>
                            <th scope="col">Number</th>
                            <th scope="col">Journal</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i = 0; $i < 5; $i++) {//count($info['entities']['journals'])
                            echo '<tr>
                            <th scope="row">' . $info['entities']['journals'][$i]['topic'] . '</th>
                            <td>' . $info['entities']['journals'][$i]['TEMP'] . '</td>
                            <td>' . $info['entities']['journals'][$i]['journal_name'] . '</td>
                            
                        </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.row -->

            <hr>

            <!-- Project Three -->
            <div class="row">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Organisation</th>
                            <th scope="col">Number</th>
                            <th scope="col">Topic</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i = 0; $i < 5; $i++) {//count($info['entities']['organisations'])
                            echo '<tr>
                            <th scope="row">' . $info['entities']['organisations'][$i]['organization'] . '</th>
                            <td>' . $info['entities']['organisations'][$i]['TEMP'] . '</td>
                            <td>' . $info['entities']['organisations'][$i]['topic'] . '</td>
                            
                        </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.row -->

            <hr>

            <!-- Project Four -->
            <div class="row">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Author</th>
                            <th scope="col">Number</th>
                            <th scope="col">Topic</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i = 0; $i < 5; $i++) {//count($info['entities']['authors'])
                            echo '<tr>
                            <th scope="row">' . $info['entities']['authors'][$i]['author'] . '</th>
                            <td>' . $info['entities']['authors'][$i]['TEMP'] . '</td>
                            <td>' . $info['entities']['authors'][$i]['topic'] . '</td>
                            
                        </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.row -->

            <hr>
            
                        <!-- Project Four -->
            <div class="row">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Discourse elements</th>
                            <th scope="col">Numbers</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i = 0; $i < 5; $i++) {//count($info['entities']['authors'])
                            echo '<tr>
                            <th scope="row">' . $info['discourse'][$i]['SUBSTRING(role,5)'] . '</th>
                            <td>' . $info['discourse'][$i]['count'] . '</td>
                            
                        </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
                        
                        <hr>

            <div class="row">
                <div class="col-md-7">
                    <script type="text/javascript">
                        google.charts.load('current', {'packages': ['corechart']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                                ['Year', <?php echo "'" . join("','", $info['subtopics']['subtopics']) . "'"; ?>],
                                ['2015', <?php
                                $download15=[];
                        foreach ($info['subtopics']['subtopics'] as $subtopic) {
                            
                             $download15[]=$info['subtopics']['info'][$subtopic]['downloads2015'];
                        }
                        echo join(",", $download15);
                        ?>],
                                    ['2016', <?php
                                    $download16=[];
                        foreach ($info['subtopics']['subtopics'] as $subtopic) {
                            
                             $download16[]=$info['subtopics']['info'][$subtopic]['downloads2016'];
                        }
                        echo join(",", $download16);
                        ?>],
                                    ['2017', <?php
                                    $download17=[];
                        foreach ($info['subtopics']['subtopics'] as $subtopic) {
                            
                            $download17[]=$info['subtopics']['info'][$subtopic]['downloads2017'];
                        }
                        echo join(",", $download17);
                        ?>3]
                            ]);

                            var options = {
                                title: 'Subtopic Performance',
                                curveType: 'function',
                                legend: {position: 'bottom'}
                            };

                            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

                            chart.draw(data, options);
                        }
                    </script>
                    <div id="curve_chart" style="width: 700px; height: 300px"></div>
                </div>
                <div class="col-md-5">
                    <h3><?php echo "Subtopics"; ?></h3>
                    <p><?php
                        foreach ($info['subtopics']['subtopics'] as $subtopic) {
                            echo $subtopic . "</br>";
                        }
                        ?></p>
                    <!--          <a class="btn btn-primary" href="#">View Project</a>-->
                </div>
            </div>


            <!-- Footer -->
            <footer class="py-5 bg-dark">
                <div class="container">
                    <p class="m-0 text-center text-white">Copyright &copy; Your Website 2018</p>
                </div>
                <!-- /.container -->
            </footer>

            <!-- Bootstrap core JavaScript -->
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>

</html>
