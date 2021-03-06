<?php
	session_start();
	require "../../Controller/attendanceController.php";
	$attendance = new attendanceController();

	date_default_timezone_set('Asia/Dhaka');

	if(isset($_GET['class']))
	{
		$class= $_GET['class'];
	}
	else {header('location:index.php');}



    $attendance->class          = $_GET['class'];
    $attendance->date           = date('d');
    $attendance->month          = date('m');
    $attendance->year           = date('Y');

    if(isset($_POST['submit']))
    {
        $attendance->attend_data    = $_POST['attand'];

        var_dump($attendance->takeAttendance());
    }


?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>

	<meta charset="UTF-8">
	<title>Attendance | HCS App</title>
	<link rel="stylesheet" href="../../src/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="../../src/fa/css/all.css" />
	<link rel="shortcut icon" href="../img/icon.ico">
	

<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />	
</head>
<body><?php include "../header.php";?>
	<div class="row m-0 p-0">
        <div class="col-md-2 m-0 p-0">
            <?php foreach ($attendance->show_classList() as $item => $value){ $clas = $value['class_id'];?>
                    <div class="w-100 bg-info mt-2 p-2 text-light font-weight-bold <?php if($clas == $_GET['class']){echo "bt-5";}?>"
                         style="cursor: pointer"
                         onclick="window.location.href='attand.php?class=<?php echo $clas;?>'" >
                        <?php echo $value['class_name'];?>
                        <span class="float-right"> <?php echo $value['shift'];?> </span>

                    </div>
            <?php } ?>
        </div>
        <div class="col-md-10">
            <?php if($attendance->attend_status() === false){ echo "Attendance Already taken"; }else{ ?>
            <form action="attand.php?class=<?php echo $_GET['class'];?>" method="post">
            <table class="table table-sm table-hover table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Name</th>
                        <th>Roll</th>
                        <th>Present</th>
                        <th>Absent</th>
                    </tr>
                </thead>
            <?php $attendance->class = $_GET['class'];
            foreach ($attendance->attendList() as $key => $value){ $obj = (object)$value; ?>

                    <tr>
                        <td> <?php echo $obj->name; ?> </td>
                        <td> <?php echo $obj->class_roll; ?> </td>
                        <td> <label for="present[<?php echo $obj->id;?>]">Present</label>
                            <input  id="present[<?php echo $obj->id;?>]" type="radio" name="attand[<?php echo $obj->id;?>]" value="1" checked>  </td>
                        <td> <label for="absent[<?php echo $obj->id;?>]">Absent</label>
                                <input type="radio" id="absent[<?php echo $obj->id;?>]" name="attand[<?php echo $obj->id;?>]" value="0"> </td>

                    </tr>




            <?php } ?>


            </table>
                <input type="submit" name="submit" value="Submit" class="btn btn-success"/>
            </form>
            <?php } ?>
        </div>
	</div>

<script>

</script>

</body>
</html>