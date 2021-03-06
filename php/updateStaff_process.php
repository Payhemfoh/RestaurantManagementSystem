<?php
    //get post value from webpage
    $position = $_POST['position'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $phoneNo = $_POST['phone'];
    $staff_id = $_POST['id'];
    $valid = true;

    //<---------------------Start Validation--------------------->
    if(empty($fname))
    {
        echo "<h3><font color = 'red'>Your first name is empty.</font></h3>";
        $valid = false;
    }
    
    if(empty($lname))
    {
        echo "<h3><font color = 'red'>Your last name is empty.</font></h3>";
        $valid = false;
    }
    
    if(empty($gender))
    {
        echo "<h3><font color = 'red'>Your gender is not selected.</font></h3>";
        $valid = false;
    }

    if(empty($position)){
        echo "<h3><font color = 'red'>Your position is not empty.</font></h3>";
        $valid = false;
    }

    if(empty($birthday))
    {
        echo "<h3><font color = 'red'>Your date of birth is empty.</font></h3>";
        $valid = false;
    }
    
    if (empty($phoneNo))
    {
        echo "<h3><font color = 'red'>Your phone number is empty.</font></h3>";
        $valid = false;
    }
    
    if (empty($email))
    {
        echo "<h3><font color = 'red'>Your email is empty.</font></h3>";
        $valid = false;
    }
    
    if (empty($username))
    {
        echo "<h3><font color = 'red'>Your username is empty.</font></h3>";
        $valid = false;
    }

    //advance checking
    
    if(!ctype_alpha($fname))
    {
        echo "<h3><font color = 'red'>Your first name all must be alphabet.</font></h3>";
        $valid = false;
    }
    
    if(!ctype_alpha($lname))
    {
        echo "<h3><font color = 'red'>Your last name all must be alphabet.</font></h3>";
        $valid = false;
    }
    
    if(!preg_match("/^[0-9]{3}-[0-9]{7}$/", $phoneNo))
    {
        echo "<h3><font color = 'red'>Your phone number is invalid.</h3></font>";
        $valid = false;
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        echo "<h3><font color = 'red'>Invalid email format.</h3></font>";
        $valid = false;
    }


    if($valid){
        //database connection
        $connect = new mysqli("localhost","root","","rms_database");

        //check connection
        if($connect->connect_error){
            die("Connection error : $connect->connect_errno : $connect->connect_error");
        }
        
        //use parameterized query to prevent sql injection
        //insert data into stock table
        if($statement = $connect->prepare("UPDATE staff SET 
                                            username = ?,
                                            email = ?,
                                            first_name = ?,
                                            last_name = ?,
                                            gender = ?,
                                            date_of_birth = ?,
                                            phone_number = ?,
                                            position_id=?
                                            
                                            WHERE staff_id = ?")){
            
            $statement->bind_param("sssssssdd",
                                    $username,
                                    $email,
                                    $fname,
                                    $lname,
                                    $gender,
                                    $birthday,
                                    $phoneNo,
                                    $position,
                                    $staff_id);

            $statement->execute();

            echo "<p>The data had been modified successfully.</p><br>";
            echo "<button id=\"btnAgain\" class=\"btn btn-block btn-lg btn-outline-primary\">Return to Menu</button>";
            
            $statement->close();
        }else{
            die("Failed to prepare SQL statement.");
        }
        $connect->close();
    }else{
        echo "<p>Failed to modify data! Click the button below to try again.</p><br>";
        echo "<button id=\"btnAgain\" class=\"btn btn-block btn-lg btn-outline-primary\">Try Again</button>";
    }
?>