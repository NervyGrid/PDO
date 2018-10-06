<?php
$dsn = 'mysql:host=localhost;dbname=college';
$username = 'root';
$password = '';
try{
    $con = new PDO($dsn,$username,$password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $ex) {  
    echo 'Not Connected '.$ex->getMessage(); 
}
$id = '';
$fname = '';
$lname = '';
$age = '';
$gender='';
$dob='';
$email='';
echo $gender;
function getPosts()
{
    $posts = array();
    $posts[0] = $_POST['id'];
    $posts[1] = $_POST['fname'];
    $posts[2] = $_POST['lname'];
    $posts[3] = $_POST['age'];
    $posts[4] = $_POST['gender'];
    $posts[5] = $_POST['dob'];
    $posts[6]=$_POST['email'];
    //echo $gender;
    return $posts;
}
if(isset($_POST['search']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        echo 'Enter The User Id To Search';
    }  else {
        
        $searchStmt = $con->prepare('SELECT * FROM test WHERE id = :id');
        $searchStmt->execute(array(
                    ':id'=> $data[0]
        ));
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                echo 'No Data For This Id';
            }
            $id    = $user[0];
            $fname = $user[1];
            $lname = $user[2];
            $age   = $user[3];
            $gender= $user[4];
            $dob=$user[5];
            $email=$user[6];
        } 
    }
}
if(isset($_POST['insert']))
{
    $data = getPosts();
    if(empty($data[1]) || empty($data[2]) || empty($data[3]))
    {
        echo 'Enter The User Data To Insert';
    }  else {
        
        $insertStmt = $con->prepare('INSERT INTO test(fname,lname,age,gender,dob,email) VALUES(:fname,:lname,:age,:gender,:dob,:email)');
        $insertStmt->execute(array(
                    ':fname'=> $data[1],
                    ':lname'=> $data[2],
                    ':age'  => $data[3],
                    ':gender'=>$data[4],
                    ':dob'=>$data[5],
                    ':email'=>$data[6]
                    //echo $gender;
        ));
        if($insertStmt)
        {
                echo 'Data Inserted';
        }   
    }
}
if(isset($_POST['update']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        echo 'Enter The User Data To Update';
    }  else {
        
        $updateStmt = $con->prepare('UPDATE test SET fname = :fname, lname = :lname, age = :age,gender = :gender,email=:email WHERE id = :id');
        $updateStmt->execute(array(
                    ':id'=> $data[0],
                    ':fname'=> $data[1],
                    ':lname'=> $data[2],
                    ':age'  => $data[3],
                    ':gender'=>$data[4],
                    ':dob'=>$dob[5],
                    ':email'=>$email[6]
                    //echo $gender;
        ));
        if($updateStmt)
        {
                echo 'Data Updated';
        }
        
    }
}
if(isset($_POST['delete']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        echo 'Enter The User ID To Delete';
    }  else {
        $deleteStmt = $con->prepare('DELETE FROM test WHERE id = :id');
        $deleteStmt->execute(array(
                    ':id'=> $data[0]
        ));
        if($deleteStmt)
        {
                echo 'User Deleted';
        } 
    }
}
if(isset($_POST['login']))
{
    $data = getPosts();
    if(empty($data[6]))
    {
        echo 'Enter The dob and email id to login';
    }  else
     {
        
        $loginStmt = $con->prepare('SELECT dob,email FROM test WHERE dob=:dob and email=:email');
        $email=$_POST['email'];
        
        if($loginStmt)
        {
            $user = $loginStmt->fetch();
            if($user[6]==$email)
            {
                echo 'ok';
            }
            else
            {
            echo "not";
            }  
        }   
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>PHP (MySQL PDO): Insert, Update, Delete, Search</title>  
    </head>
    <body>
        <form action="test.php" method="POST">

            <input type="text" name="id" placeholder="id" value="<?php echo $id;?>"><br><br>
            <input type="text" name="fname" placeholder="First Name" value="<?php echo $fname;?>"><br><br>
            <input type="text" name="lname" placeholder="Last Name" value="<?php echo $lname;?>"><br><br>
            <input type="number" min="10" max="100" name="age" placeholder="Age" value="<?php echo $age;?>"><br><br>
            <input type="date" name="dob" value="<?php echo $dob;?>">
            <input type="submit" name="insert" value="Insert">
            <input type="submit" name="update" value="Update">
            <input type="submit" name="delete" value="Delete">
            <input type="submit" name="search" value="Search">
            <input type="email" name="email" value="<?php echo $email;?>">
            Male<input type="radio" name="gender" id="male" value="male" <?php echo ($gender=='male')?'checked':''?>>
            Female<input type="radio" name="gender" value="female" <?php echo ($gender=='female')?'checked':''?> ><br>
        <input type="submit" name="login" value="login">
        </form>  
    </body>    
</html>