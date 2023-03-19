<head>
</head>
<body>  
<?php
require("db.php");
if(isset($_COOKIE['tb_name'])){
   $table_name=$_COOKIE['tb_name'];
}else{
    $query="select * from table_name";
    $all=mysqli_query($connection,$query);
    $flag_same=true;
    while($flag_same==true){
        $flag_same=false;
    $table_rand_name=rand(20,99999999);
    $table_rand_name="A".$table_rand_name;
    while($row=mysqli_fetch_assoc($all)){
        if($table_rand_name==$row['name']){
            $flag_same=true;
        }
    }
    
}
$query="insert into table_name (name) values('$table_rand_name')";
mysqli_query($connection,$query);
setcookie("tb_name", $table_rand_name);
$table_name=$table_rand_name;
}
session_start();
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$query = "DROP TABLE IF EXISTS saipa.$table_name";
mysqli_query($connection, $query);
if (isset($_POST['submit_file']) && isset($_FILES['upload_file']))
{
    $name = $_FILES['upload_file']['name'];
    list($txt, $ext) = explode(".", $name);
    $excel_name = time() . "." . $ext;
    $tmp = $_FILES['upload_file']['tmp_name'];
    if (move_uploaded_file($tmp, 'upload/' . $excel_name))
    {

        $inputFileType = 'Xlsx';

        $inputFileName = "upload/$excel_name";
        $reader = IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($inputFileName);

        $sheetdata = $spreadsheet->getActiveSheet()
            ->toArray(null, true, true, false);

        $columns = $sheetdata[0];
        
        $columns = implode("','", $columns);
        $columns = explode("','", $columns);
        $column_count = count($columns);
        $record_count = count($sheetdata);
		echo $record_count;
        $digit_pattern = "/^[0-9]*$/";
        $date_pattern = "/_DATE/";
        $sample = $sheetdata[1];
        $sample = implode("','", $sample);
        $sample = explode("','", $sample);

        $create_query = "CREATE TABLE IF NOT EXISTS $table_name (  ";
        $insert_query = "insert into $table_name (";
        $i = 0;
        $index = 0;
        $count = 0;

        foreach ($columns as $column)
        {

            if ($i == 0)
            {

                if (preg_match($date_pattern, $column) == 1)
                {
                    $min_record_count = 0;
                    $min_column_count = 0;
                    while ($min_record_count < $record_count)
                    {
                        while ($min_column_count < $column_count)
                        {

                            if ($count == $min_column_count)
                            {
                                $EXCEL_DATE = $sheetdata[$min_record_count][$count];
                                $UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
                                $sheetdata[$min_record_count][$count] = gmdate("Y-m-d", $UNIX_DATE);

                            }
                            $min_column_count++;
                        }
                        $min_record_count++;
                    }

                    $create_query = $create_query . $column . " DATE ";
                    $insert_query = $insert_query . $column . " ";
                    $i = 1;

                }
                else if (preg_match($digit_pattern, $sample[$index]) == 1)
                {

                    $create_query = $create_query . $column . " BIGINT ";
                    $insert_query = $insert_query . $column . " ";
                    $i = 1;
                }
                else
                {
                    $create_query = $create_query . $column . " varchar(255) ";
                    $insert_query = $insert_query . $column . " ";
                    $i = 1;
                }

                $i = 1;
            }
            else
            {

                // if(preg_match($digit_pattern, $sample[$index])==1){
                //   $create_query=$create_query." ,".$column." int(90) ";
                //    $insert_query=$insert_query." ,".$column;
                //    $i=1;
                // }else
                if (preg_match($date_pattern, $column) == 1)
                {
                    $min_record_count = 1;
                    $min_column_count = 0;

                    while ($min_column_count < $column_count)
                    {

                        if ($count == $min_column_count)
                        {
                            while ($min_record_count < $record_count)
                            {
                                $EXCEL_DATE = $sheetdata[$min_record_count][$count];

                                $UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
                                $sheetdata[$min_record_count][$count] = gmdate("Y-m-d", $UNIX_DATE);
                                $min_record_count++;
                            }

                        }
                        $min_column_count++;
                    }

                    $create_query = $create_query . " ," . $column . " DATE ";
                    $insert_query = $insert_query . " ," . $column . " ";
                    $i = 1;

                }
                else if (preg_match($digit_pattern, $sample[$index]) == 1)
                {

                    $create_query = $create_query . " ," . $column . " BIGINT ";
                    $insert_query = $insert_query . " ," . $column . " ";
                    $i = 1;
                }
                else
                {
                    $create_query = $create_query . " ," . $column . " varchar(255) ";
                    $insert_query = $insert_query . " ," . $column . " ";
                    $i = 1;
                }

            }
            $index++;
            $count++;
        }

        $create_query = $create_query . ")";
        mysqli_query($connection, $create_query);
        $i = 0;
        $insert_query = $insert_query . ")" . " values(";
        $min_record_count = 1;
        $static_query = $insert_query;
        while ($min_record_count < $record_count)
        {
            $record = implode("','", $sheetdata[$min_record_count]);
            $record = explode("','", $record);
            $min_column_count = 0;

            $i = 0;
            $insert_query = $static_query;
            while ($min_column_count < $column_count)
            {

                if ($i == 0)
                {
                    $insert_query = $insert_query . "'" . $record[$min_column_count] . "'";
                    $i = 1;
                }
                else
                {
                    $insert_query = $insert_query . " ," . "'" . $record[$min_column_count] . "'";
                }

                $min_column_count++;

            }
            $min_record_count++;
            $insert_query = $insert_query . ")";
            
            mysqli_query($connection, $insert_query);

        }
		$_SESSION['sheetdata']=$sheetdata;
        header("Location: data.php");
        

    }
    else
    {
        echo '<script>alert("مشکل در آپلود فایل")</script>';
		header("Location: index.php");

    }
}

?>
</body>  
