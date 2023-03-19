<html lang="en">
<head>
    <title>Data Filtering</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" >
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
    <script src="http://malsup.github.com/jquery.form.js"></script> 
    <link rel="stylesheet" type="text/css" href="progress_style.css">
	
  <script type="text/javascript" src="jquery.js"></script>
  <script type="text/javascript" src="jquery.form.js"></script>
  <script type="text/javascript" src="upload_progress.js"></script>
  <script>
    


    </script>
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid text-center">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Excel Custom Report</a>
			</div>
		</div>
	</nav>
	<div class="container text-center">
		<h2>فایل اکسل خود را آپلود کنید</h2>
		<div style="border: 1px solid #a1a1a1;text-align: center;width: 500px;padding:30px;margin:0px auto">
			<form action="upload_file.php" enctype="multipart/form-data" class="form-horizontal" method="post" id="myForm" name="frmupload">


				


				<input type="file" class="form-control" id="upload_file" name="upload_file" />
                <br>
				<button class="btn btn-primary upload-image" type="submit" name='submit_file' value="Submit Content" onclick='upload_file();'>آپلود</button>

				
			</form>
            
    
</body>
</html>