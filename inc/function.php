<?php
define('DB_Name','G:/xampp/htdocs/php/CRUD/data/db.txt');

function seed($filename){
    $data = array(
        array(
            'id'=>1,
            'fname'=>'Tuhin',
            'lname'=>'khan',
            'roll'=>10
        ),
        array(
            'id'=>2,
            'fname'=>'Jamal',
            'lname'=>'khan',
            'roll'=>14
        ),
        array(
            'id'=>3,
            'fname'=>'Kamal',
            'lname'=>'khan',
            'roll'=>15
        ),
        array(
            'id'=>4,
            'fname'=>'Rahim',
            'lname'=>'Hassan',
            'roll'=>13
        ),
        array(
            'id'=>5,
            'fname'=>'Karim',
            'lname'=>'khan',
            'roll'=>12
        ),
    );

    $serializedData = serialize($data);
    file_put_contents($filename,$serializedData,LOCK_EX);
}


function generateReport($filename){
    $data = file_get_contents($filename);
    $students = unserialize($data);
?>
    <table>
        <tr>
            <th>Name</th>
            <th>Roll</th>
            <th width="25%" >Action</th>
        </tr>
        <?php foreach($students as $student){
            ?>
             <tr>
                 <td><?php printf("%s %s",$student['fname'],$student['lname']); ?></td>
                 <td><?php printf("%s",$student['roll']); ?></td>
                 <td><?php printf('<a href ="index.php?task=edit&id=%s">EDIT</a> | <a href ="index.php?task=delete&id=%s">DELETE</a>',$student['id'],$student['id']); ?></td>
             </tr>
            <?php
        }
        ?>
    </table>
<?php
}

function addnewStudent($fname,$lname,$roll){
    $serializedData = file_get_contents(DB_Name);
    $students = unserialize($serializedData);
    $found = false;
    foreach($students as $_student){
        if($_student['roll']==$roll){
            $found = true;
        break;
        }
    }
    if(!$found){
    $newID = getnewID($students);

    $student = array(
        'id'=>$newID,
        'fname'=>$fname,
        'lname'=>$lname,
        'roll'=>$roll
    );

    array_push($students,$student);
    $serializData = serialize($students);
    file_put_contents(DB_Name,$serializData,LOCK_EX);
        return true;
    }
    return false;
}

function getStudent($id){
    $serializedData = file_get_contents(DB_Name);
    $students = unserialize($serializedData);
    foreach($students as $student){
        if($student['id']==$id){

            return $student;
        }
    }
    return false;
}


function updateStudent($id,$fname,$lname,$roll){
    $found = false;
    $serializedData = file_get_contents(DB_Name);
    $students = unserialize($serializedData);
    foreach($students as $_student){
        if($_student['roll']==$roll && $_student['id']!=$id){
            $found = true;
        break;
        }
    }
    if(!$found){
        $students[$id-1]['fname']=$fname;
        $students[$id-1]['lname']=$lname;
        $students[$id-1]['roll']=$roll;


        $serializedData = serialize($students);
        file_put_contents(DB_Name,$serializedData,LOCK_EX);
        return true;

    }
    return false;

}


function deleteStudent($id){
    $serializedData = file_get_contents(DB_Name);
    $students = unserialize($serializedData);

    unset($students[$id-1]);

    $serializedData = serialize($students);
    file_put_contents(DB_Name,$serializedData,LOCK_EX);
}

function getnewID($students){
    $maxID = max(array_column($students,'id'));
    return $maxID+1;
}


function isAdmin(){
  return('admin'== $_SESSION['role']);
}


?>
