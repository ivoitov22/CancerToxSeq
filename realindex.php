<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kidney Data with Graphs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-image: url('whiteBack.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            color: white;
        }
        .card {
            margin: auto;
            width: 80%;
            border: 1px solid rgba(0, 255, 0, 0.4);
        }
        .table-wrapper {
            max-height: 300px;
            overflow-y: auto;
            overflow-x: auto;
        }
        .table {
            text-align: center;
        }
        .card-header {
            background-color: rgba(0, 255, 0, 0.2);
        }
        canvas {
            background-color: white;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Search Form -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="search" placeholder="Search here..." value="<?php if (isset($_GET['search'])) { echo $_GET['search']; } ?>">
                        <button type="submit" class="btn btn-primary" style="color:black;">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table and Graph Section -->
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">Kidney Data</h4>
                    </div>
                    <div class="card-body">
                        <!-- Dropdowns for Axis Selection -->
                        <div class="row justify-content-center mb-4">
                            <div class="col-md-6">
                                <label for="x-axis" class="form-label">Select X-Axis Variable:</label>
                                <select id="x-axis" class="form-select">
                                    <option value="pvalue">P Value</option>
                                    <option value="ratio">Ratio</option>
                                    <option value="fold">Fold Change</option>
                                    <option value="mean">LS Mean</option>
                                    <option value="control">LS Mean Control</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="y-axis" class="form-label">Select Y-Axis Variable:</label>
                                <select id="y-axis" class="form-select">
                                    <option value="pvalue">P Value</option>
                                    <option value="ratio">Ratio</option>
                                    <option value="fold">Fold Change</option>
                                    <option value="mean">LS Mean</option>
                                    <option value="control">LS Mean Control</option>
                                </select>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-wrapper">
                            <table class="table table-bordered" style="background-color:white;" id="data-table">
                                <thead>
                                    <tr>
                                        <th>Symbol</th>
                                        <th>Name</th>
                                        <th>P Value</th>
                                        <th>FDR Step Up</th>
                                        <th>Ratio</th>
                                        <th>Fold Change</th>
                                        <th>LS Mean</th>
                                        <th>LS Mean Control</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if (isset($_GET['search'])) {
                                            $connection = mysqli_connect("localhost", "root", "", "genes");
                                            $filtervalue = $_GET['search'];
                                            $filterdata = "SELECT * FROM kidneys WHERE CONCAT(symbol, name, pvalue, stepup, ratio, fold, mean, control) LIKE '%$filtervalue%'";
                                            $filterdata_run = mysqli_query($connection, $filterdata);

                                            if (mysqli_num_rows($filterdata_run) > 0) {
                                                foreach ($filterdata_run as $row) {
                                                    echo "<tr>";
                                                    echo "<td>{$row['symbol']}</td>";
                                                    echo "<td>{$row['name']}</td>";
                                                    echo "<td>{$row['pvalue']}</td>";
                                                    echo "<td>{$row['stepup']}</td>";
                                                    echo "<td>{$row['ratio']}</td>";
                                                    echo "<td>{$row['fold']}</td>";
                                                    echo "<td>{$row['mean']}</td>";
                                                    echo "<td>{$row['control']}</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='8'>No record found</td></tr>";
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Chart -->
                        <canvas id="dataChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Chart.js
        const ctx = document.getElementById('dataChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [], // Placeholder for x-axis labels
                datasets: [{
                    label: 'Graph',
                    data: [], // Placeholder for y-axis data
                    borderColor: 'rgba(0, 255, 0, 0.7)',
                    backgroundColor: 'rgba(0, 255, 0, 0.2)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Function to update the graph based on table data
        function updateGraph() {
            const xAxis = document.getElementById('x-axis').value;
            const yAxis = document.getElementById('y-axis').value;
            const table = document.getElementById('data-table');
            const rows = table.querySelectorAll('tbody tr');
            const xValues = [];
            const yValues = [];

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                if (cells.length > 0) { // Skip rows with "No record found"
                    const xValue = parseFloat(cells[xAxis === 'pvalue' ? 2 : xAxis === 'ratio' ? 4 : xAxis === 'fold' ? 5 : xAxis === 'mean' ? 6 : 7].textContent);
                    const yValue = parseFloat(cells[yAxis === 'pvalue' ? 2 : yAxis === 'ratio' ? 4 : yAxis === 'fold' ? 5 : yAxis === 'mean' ? 6 : 7].textContent);
                    xValues.push(xValue);
                    yValues.push(yValue);
                }
            });

            // Update Chart.js data
            myChart.data.labels = xValues;
            myChart.data.datasets[0].data = yValues;
            myChart.data.datasets[0].label = `${xAxis} vs ${yAxis}`;
            myChart.update();
        }

        // Add event listeners for dropdowns
        document.getElementById('x-axis').addEventListener('change', updateGraph);
        document.getElementById('y-axis').addEventListener('change', updateGraph);

        // Initial graph update
        updateGraph();
    </script>
</body>
</html>