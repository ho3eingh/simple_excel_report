<!doctype html>
<?php
 $table_name=$_COOKIE['tb_name'];
 
session_start();
require("db.php");
if(isset($_POST['re_upload'])){
    session_destroy();
    header("Location: index.php");
}

?>
<html lang="en">
  <head>
  <link rel="stylesheet" href="css/loading.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
 
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

    <title>Data</title>
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
  <div class="loader">
        <div></div>
    </div>

  <div class="content">
    
    <div class="container">
      <h2 class="mb-5">
        <form action='data.php' method='POST'>
      <?php
$digit_pattern="/^[0-9]*$/";
$date_pattern="/_DATE/";

       $sheetdata=$_SESSION['sheetdata'];
       $sample=$sheetdata[1];
       $sample=implode("','",$sample);
       $sample=explode("','",$sample);
       $columns=$sheetdata[0];
       array_splice($sheetdata, 0, 1); 

       $i=0;
       foreach($columns as $column){
        $i++;
        if(preg_match($date_pattern,$column)==1){
            echo"<br>";
            echo"<label>$column Start:&nbsp; </label>";
            echo"<input name='start_$column' type='date' />";
            echo"&nbsp;";
            echo"<label>$column End:&nbsp; </label>";
            echo"<input name='end_$column' type='date' />";
            
            echo"<br>";
        }else{
        echo"<input name='$column' type='text' placeholder='Filtered By $column'/>";
        echo"&nbsp;";
        }
        if(($i%4)==0){
            echo"<br>";
            
        }
       }

      ?>
      <br>
      <button class="btn btn-primary upload-image" type="submit" name='apply_filters' value="Submit filter">اعمال فیلتر</button>
      <br>
      <br>
      <button class="btn btn-primary upload-image" type="submit" name='reset' value="reset">Reset</button>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <button class="btn btn-primary upload-image" type="submit" name='re_upload' value="Submit re_upload">آپلود مجدد فایل</button>
     
       
      </h2>
      
     <?php  $ii=0;
     $i=0;
      if(isset($_POST['apply_filters'])){
                 $query="select * from $table_name where ";
                 
                 foreach($columns as $column){
                    $date_sample="start_$column";
                    if(isset($_POST[$column])){
                       
                      if(($_POST[$column])!=""){
                          
                          
                          if($ii==0){
                              $query=$query.$column." REGEXP "."'".$_POST[$column]."'";
                              $ii=1;
                          }else{
                              $query=$query." AND ".$column." REGEXP "."'".$_POST[$column]."'";
                          }
                          $i=1;
                          $flag=1;
                      }
                    // }else if(isset($_POST[$date_sample])){
            
                    //           $end_sample="end_$column";
                    //           $start=$_POST[$date_sample];
                    //           $end=$_POST[$end_sample];
                    //   if($i==0){
                    //     $query=$query.$column." BETWEEN "." '$start' "." AND "." '$end' ";
                    //           $i=1;
            
                    //   }else{
                    //     $query=$query." AND ".$column." BETWEEN "." '$_POST[$date_sample]' "." AND "." '$end_sample' ";
                    //           $i=1;
            
                    //   }
                    // }
                    
                  }else if(isset($_POST[$date_sample])&&!empty($_POST[$date_sample])){

                    $end_sample="end_$column";
                    $start=$_POST[$date_sample];
                    $end=$_POST[$end_sample];
            if($i==1){
                
                if($flag==1){
                    $query=$query." AND ".$column." BETWEEN "." '$start' "." AND "." '$end' ";
                    
                }else{
                    $query=$query.$column." BETWEEN "." '$start' "." AND "." '$end' ";
                    
                }
              
  
            }else{
               
                    $query=$query.$column." BETWEEN "." '$start' "." AND "." '$end' ";
                    $ii=1;
                
             
                    
  
            }
          }
                  
            }
            
            
            if($query=="select * from $table_name where "){
                echo '<script>alert("ابتدا فیلتر خود را انتخاب کنید!")</script>';
               
                
            }else{
                
                $all_filtered_data=mysqli_query($connection,$query);
            
            
                $i=0;
                $j=0;
                $sheetdata=array();
                if(isset($_POST['fields'])){
                    $columns=array();
                    foreach($_POST['fields'] as $field){

                        array_push($columns,$field);  
                                
                    }
                }
                while($row=mysqli_fetch_assoc($all_filtered_data)){
                    if(isset($_POST['fields'])){
                        
                         
                        foreach($_POST['fields'] as $field){
                            $j++;
                            $sheetdata[$i][$j]=$row[$field];
                            
                        }
                        $j=0;
                        $i++;
                        
                        
                
                    }else{
                       
                        foreach($columns as $column){
                            $j++;
                            $sheetdata[$i][$j]=$row[$column];
                            
                        }
                        $j=0;
                        $i++;

                    }
                    
                   
                }
            }
        }

          if(isset($_POST['apply_fields'])){
            
             if(isset($_POST['fields'])){
              
                $_SESSION['fields_flag']=1;
                
                $select_query="select ";
                $columns=array();
                $i=0;
                foreach($_POST['fields'] as $field){

                    array_push($columns,$field);  
                    if($i==1){
                        $select_query=$select_query.","."$field";
                    }else{
                        $select_query=$select_query."$field";
                        $i=1;
                        
                    }          
                }
                $select_query=$select_query." from $table_name";
                
                $all_filtered_data=mysqli_query($connection,$select_query);
                $i=0;
                $j=0;
                $sheetdata=array();
                while($row=mysqli_fetch_assoc($all_filtered_data)){
                    foreach($_POST['fields'] as $field){
                        $j++;
                        $sheetdata[$i][$j]=$row[$field];
                        
                    }
                    $j=0;
                    $i++;
                   
                }
             }else{
                echo '<script>alert("فیلد های مورد نظر را انتخاب کنید!")</script>';
             }
           
          }
          $content="";
          $content=$content."<style>
    table, td, th {  
      border: 1px solid #ddd;
      text-align: left;
      border-collapse: collapse;
      padding: 10px;
    }
    </style>";
          ?>
      <div class="table-responsive custom-table-responsive">
      <div class="scrollit">
        <table class="table custom-table">
          <thead>
            <tr>  

              
            
             <?php
             $content=$content."<table><thead><tr>";
              foreach($columns as $column){
                $content=$content."<th>$column</th>";
               echo" <th scope='col'>
               <input type='checkbox' name='fields[]' value='$column'/>
               $column
               </th>";
              }



             ?>
             
            </tr>
          </thead>
          
          <tbody>
         
            <?php
            $content=$content."</tr></thead><tbody>";
            $sheet_count=count($sheetdata);
            for($i=0;$i<$sheet_count;$i++){
                echo"<tr>";
                $content=$content."<tr>";
                // echo"<th scope='row'>";
                // echo"<label class='control control--checkbox'>";
                // echo"<input type='checkbox'/>";
                // echo"<div class='control__indicator'></div>";
                // echo"</label>";
                // echo"</th>";

                 foreach($sheetdata[$i] as $data){
                    $content=$content."<td>$data</td>";
                    echo"<td>$data</td>";
                 }
                 echo"</tr>";
                 $content=$content."</tr>";
            }
            // <tr scope="row">
            //   <th scope="row">
            //     <label class="control control--checkbox">
            //       <input type="checkbox"/>
            //       <div class="control__indicator"></div>
            //     </label>
            //   </th>     
            $content=$content."</tbody> </table>";
            $_SESSION['content']=$content;
            $_SESSION['columns_chart']=$columns;
            $_SESSION['sheetdata_chart']=$sheetdata;
                    ?>
                    
          </tbody>
          
        </table>
        </div>
        </div>
        <br>
        
        <button class="btn btn-primary upload-image" type="submit" name='apply_fields' value="Submit filter">نمایش فیلد های انتخابی</button>

        
        </form>
        <form action="charts.php" method="POST">
        <button class="btn btn-primary upload-image" type="submit" name='charts' value="charts">نمودار ها</button>
        </form>
        
        <form action="download_export.php" method="POST">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;
      
        

            <label>فایل خروجی:</label>
            <select name="ex_type">
                <option value="pdf">PDF</option>
        </select>
        <button  type="submit" name='apply_fields' value="Submit filter">دانلود</button>
        
        </form>
      </div>


    

  </div>
    
    

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        $(window).on('load',function(){
            $(".loader").fadeOut(1000);
            $(".content").fadeIn(1000);
        });
    </script>
  </body>
</html>