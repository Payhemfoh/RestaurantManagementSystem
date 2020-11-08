<?php
    function passwordEncrypt(string $password):string{
        return hash("sha256",$password."Welcome To Restaurant Management Module");
    }

    //get post value from webpage
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmPassword'];
    $newPassword = $_POST['newpassword'];
    $email = $_POST['email'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $phoneNo = $_POST['phone'];
    $valid = true;

    //validation


    if($valid){
        //database connection
        $connect = new mysqli("localhost","root","","rms_database");

        //check connection
        if($connect->connect_error){
            die("Connection error : $connect->connect_errno : $connect->connect_error");
        }
        
        //use parameterized query to prevent sql injection
        //insert data into stock table
        if($statement = $connect->prepare("UPDATE customer SET 
                                            username = ?,
                                            email = ?,
                                            first_name = ?,
                                            last_name = ?,
                                            gender = ?,
                                            date_of_birth = ?,
                                            phone_number = ?
                                            
                                            WHERE customer_id = ?")){
            
            $statement->bind_param("sssssssdd",
                                    $username,
                                    $email,
                                    $fname,
                                    $lname,
                                    $gender,
                                    $birthday,
                                    $phone);

            $statement->execute();

            if($statement->get_result()){
                echo "<p>The data had been modified successfully.</p><br>";
                echo "<button id=\"btnAgain\" class=\"btn btn-block btn-lg btn-outline-primary\">Return to Menu</button>";
            }else{
                echo "<p>Failed to insert data into database.</p><br>";
                echo "<button id=\"btnAgain\" class=\"btn btn-block btn-lg btn-outline-primary\">Return to Menu</button>";
            }
            
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