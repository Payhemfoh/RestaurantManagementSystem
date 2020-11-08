<!DOCTYPE html>
<html lang="en">
    <head>
        <title>RMS | Homepage</title>
        <?php
            require("../php/pageFragment.php");
            printHeadInclude();
        ?>
    </head>

    <body class="bg-light">
        <?php printHeader(basename(__FILE__));?>

        <br/>
        <div id="content" class="container bg-light col-md-9 rounded">
            <br><h3 class="text-center">Your Order List</h3><br>
            
                

                
                <?php
                    //get cart from cookies
                    if(isset($_COOKIE['orderList'])){
                        $orderList = json_decode($_COOKIE['orderList']);

                        //database connection
                        $connect = new mysqli("localhost","root","","rms_database");

                        //check connection
                        if($connect->connect_error){
                            die("Connection error : $connect->connect_errno : $connect->connect_error");
                        }

                        echo '
                        <table class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Image</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Details</th>
                                </tr>
                            </thead>
                            <tbody>';
                        foreach($orderList as $id => $qty){
                            if($statement = $connect->prepare("SELECT * FROM menu m WHERE menu_id = ? LIMIT 1;")){
                                $statement->bind_param($id);
                                $statement->execute();
                                $result = $statement->get_result();

                                while($row = $result->fetch_array()){
                                    echo "<tr>
                                        <td scope=\"row\"><img src=\"".$row['menu_picture']."\" class=\"img-thumbnail\"></td>
                                        <td>".$row['menu_name']."</td>
                                        <td>".qty."</td>
                                        <td><button class=\"btn btn-info btn-detail\" value=\"".$row['menu_id']."\">Details</button></td>
                                    </tr>";
                                }

                                $statement->close();
                            }else{
                                die("Failed to prepare SQL statement.");
                            }
                        }
                        
                        echo '</tbody>
                        </table>
                        <button class="btn btn-block btn-primaryLight btn-primary">Place Order</button>
                        <a href="payment.html" class="btn btn-block btn-primaryLight btn-primary">Make Payment</a><br><br>';
                        
                        $connect->close();
                    }else{
                        echo "<p class='center'>No order found in the cart. Click the button below to start your order.<p>";
                        echo "<a href=\"../webpage/homepage.php\" class='btn btn-block btn-primaryLight btn-primary'>Start Order</a><br>";
                    }

                ?>
                
        </div>
        <br/>

        <?php printModal(); ?>
        <?php printFooter();?>

        <script type="module" src="../javascript/orderCart_script.js"></script>
    </body>
</html>