<!DOCTYPE html>
<?php
require("db.php");
session_start();
if(isset($_POST['back'])){
  header("Location: data.php");
}
?>

<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    

    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">


    <title>Table #5</title>
    <style>
        .scrollit {
    overflow:scroll;
    height:500px;
}
        input[type=text]{
  
  border:2px solid #aaa;
  border-radius:4px;
  margin:8px 0;
  outline:none;
  padding:8px;
  box-sizing:border-box;
  transition:.3s;
}

input[type=text]:focus{
  border-color:dodgerBlue;
  box-shadow:0 0 8px 0 dodgerBlue;
}
    </style>    
  </head>
  <body>
  
  
  <form action="charts.php " method="POST" enctype="multipart/form-data">
  <div class="content">
    
    <div class="container">
      <h2 class="mb-5">
  <select name="chart">
    <option value=''>نمودار را انتخاب کنید</option>
    <option value='pie'>Pie Chart</option>
   
</select>
<button class="btn btn-primary upload-image" type="submit" name="add_chart" value="add_chart"> افزودن </button>
<button class="btn btn-primary upload-image" type="submit" name="back" value="back"> بازگشت </button>


<?php
if(isset($_POST['add_chart'])){
if(isset($_POST['chart'])){
    if($_POST['chart']=="pie"){
         $_SESSION['pie_flag']=true;
         $columns=$_SESSION['columns_chart'];
         
         
         $sheetdata=$_SESSION['sheetdata_chart'];
         $count_sheetdata=count($sheetdata);
         echo"<br>";
         echo"<br>";
        echo"Name: ";
       echo"<select name='name'>";
        foreach($columns as $column) {
           
            
            echo"<option value='$column'>$column</option>";
            
        }
        echo"</select>";
        echo"value: ";
        echo" <select name='value'>";
        foreach($columns as $column) {
            
            
            echo"<option value='$column'>$column</option>";
            
        }
        echo"</select>";
       // print_r($rows);
       
       echo"&nbsp;&nbsp;";
       echo"<button class='btn btn-primary upload-image' type='submit' name='apply_charts' value='apply_charts'> نمایش نمودار</button>";
    
}else{
    unset($_SESSION['pie_flag']);
}
}
}
if(isset($_POST['add_chart'])){
  
}
?>



  
  <?php

 if(isset($_POST['apply_charts'])&&isset($_SESSION['pie_flag'])){
  $columns=$_SESSION['columns_chart'];
  $sheetdata=$_SESSION['sheetdata_chart'];
  $count_sheetdata=count($sheetdata);
    $item = $_POST['name'];
    $i=0;
    $name_index;
       foreach($columns as $column){
         if($column=="$item"){
         $name_index=$i;
         }
         $i++;
       }
       $item = $_POST['value'];
    $i=0;
    $value_index;
       foreach($columns as $column){
         if($column=="$item"){
         $value_index=$i;
         }
         $i++;
       }
      //  $query="select $item from tablee";
      //  $result=mysqli_query($connection,$query);
      //  $names=array();
      //  $i=0;
      //  while($row=mysqli_fetch_assoc($result))
      //  {
      //   $z="'".$item."'";
      //    $names[$i]=$row[$item];
      //    $i++;
      //  }
      //  $item=$_POST['value'];
    
      //  $query="select $item from tablee";
      //  $result=mysqli_query($connection,$query);
      //  $values=array();
      //  $i=0;
      //  while($row=mysqli_fetch_assoc($result))
      //  {
      //   $z="'".$item."'";
      //    $values[$i]=$row[$item];
      //    $i++;
      //  }
    
        
   
?>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([<?php 
        $count=0; 
        for($i=0;$i<$count_sheetdata;$i++){
          $sheet=$sheetdata[$i][$value_index];
          echo"['".$sheetdata[$i][$name_index]."', $sheet],";
        }
        ?>    
        ]);

       
        var options = {'title':'Pie Chart',
                       'width':400,
                       'height':300};

        
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>

   <div id="chart_div"></div>
   <?php

    }else  if(isset($_POST['apply_charts'])&&isset($_SESSION['line_flag'])){


    }
?>
  
    <!--Div that will hold the pie chart-->
    
    
    </h2>
</div>
</div>
    </form>
    
    </body>
</html>