<?php
require_once('inc//function.php');
$info = '';
$error = $_GET['error'] ?? '0';
$task = $_GET['task'] ?? 'report';

if('delete'==$task){
    $Id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);
    deleteStudent($Id);
    header('location:index.php?task=report');
}
if('seed'==$task){
    seed(DB_Name);
    $info = "Seeding is complete";
}
$fname ='';
$lname='';
$roll='';
if(isset($_REQUEST['submit'])){
    $fname = filter_input(INPUT_POST,'fname',FILTER_SANITIZE_STRING);
    $lname = filter_input(INPUT_POST,'lname',FILTER_SANITIZE_STRING);
    $roll = filter_input(INPUT_POST,'roll',FILTER_SANITIZE_STRING);
    $id = filter_input(INPUT_POST,'Id',FILTER_SANITIZE_STRING);
}
if($id){
    //update student
    $result = updateStudent($id,$fname,$lname,$roll);
    if($result){
        header('location:index.php?task=report');
    }else{
        $error = 1;
    }
}else{
    //add student
    if($fname!=''&& $lname!='' && $roll!=''){
        $result= addnewStudent($fname,$lname,$roll);
        if($result){
            header('location:index.php?task=report');
        }else{
            $error = 1;
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud Project</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">
    <style>
    body{
        margin-top: 30px;
    }
    </style>
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="column column-60 column-offset-20">
                <h1>Project 2-CRUD</h1>
                <p>A sample project to perform crud operations using plain files and PHP</p>
                <?php include_once("G:/xampp/htdocs/php/CRUD/inc/templates/nav.php"); ?>
                <hr/>
                <?php if($info!=''){
                    echo "<p>{$info}</p>";
                } ?>
            </div>
        </div>

        <?php if('1'==$error): ?>
        <div class="row">
            <div class="column column-60 column-offset-20">
                <blockquote>
                Duplicate roll number found!
                </blockquote>
            </div>
        </div>
          <?php endif;?>

          <?php if('report'==$task): ?>
        <div class="row">
            <div class="column column-60 column-offset-20">
                <?php generateReport(DB_Name); ?>
            </div>
        </div>
          <?php endif;?>

          <?php if('add'==$task): ?>
        <div class="row">
            <div class="column column-60 column-offset-20">
                <form action="index.php?task=add" method="POST">
                    <label for="fname">First Name</label>
                    <input type="text" name="fname" id="fname" value="<?php echo $fname;?>">
                    <label for="lname">Last Name</label>
                    <input type="text" name="lname" id="lname" value="<?php echo $lname;?>">
                    <label for="roll">Roll</label>
                    <input type="number" name="roll" id="roll" value="<?php echo $roll;?>">
                    <button type="submit" name="submit" class="button-primary">Submit</button>
                </form>
            </div>
        </div>
          <?php endif;?>

          <?php
            if('edit'== $task):
            $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);
            $student = getStudent($id);
            if($student):
          ?>
        <div class="row">
            <div class="column column-60 column-offset-20">
                <form method="POST">
                    <input type="hidden" name="Id" value="<?php echo $id;?>">
                    <label for="fname">First Name</label>
                    <input type="text" name="fname" id="fname" value="<?php echo $student['fname'];?>">
                    <label for="lname">Last Name</label>
                    <input type="text" name="lname" id="lname" value="<?php echo $student['lname'];?>">
                    <label for="roll">Roll</label>
                    <input type="number" name="roll" id="roll" value="<?php echo$student['roll']?>">
                    <button type="submit" name="submit" class="button-primary">Update</button>
                </form>
            </div>
        </div>
          <?php endif;?>
    <?php endif;?>







    </div>

</body>
</html>
