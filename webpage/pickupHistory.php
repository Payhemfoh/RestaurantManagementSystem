<!DOCTYPE html>
<html lang="en">
    <head>
        <title>RMS|Completed Pick Up History</title>
        <?php 
            require("../php/sessionFragment.php");
            require("../php/pageFragment.php");
            printHeadInclude();
        ?>
    </head>

    <body class="bg-light">
        <?php printHeader(basename(__FILE__));?>

        <br/>
        <div id="content" class="container bg-light col-md-6 rounded">
        <br>
            <div class="h2 text-center">Completed Pick Up History</div>
            <br>
            <table id="history_table" class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Username</th>
                        <th scope="col">Contact No</th>
                        <th scope="col">Pick Up Time</th>
                        <th>Details</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        //database connection
                        $connect = new mysqli("localhost","root","","rms_database");

                        //check connection
                        if($connect->connect_error){
                            die("Connection error : $connect->connect_errno : $connect->connect_error");
                        }
                        
                        //use parameterized query to prevent sql injection
                        //insert data into stock table
                        if($statement = $connect->prepare("SELECT o.order_id, o.pickup_time, c.username, c.phone_number
                                                            FROM orders o, customer c
                                                            WHERE o.order_type='take_away'
                                                            AND o.pickup_time is not null
                                                            AND o.customer_id = c.customer_id
                                                            ORDER BY o.pickup_time desc;")){
                            $statement->execute();
                            $result = $statement->get_result();
                            while($row = $result->fetch_assoc()){
                            printf( '<tr>
                                        <td> %s</td>
                                        <td> %s</td>
                                        <td> %s</td>
                                        <td><button class=\'btn btn-block btn-primaryLight btn-primary btn_detail\' value=\'%d\'>Details</button></td>
                                    </tr>',
                                    $row["username"],
                                    $row['phone_number'],
                                    $row["pickup_time"],
                                    $row['order_id']);
                            }

                            $statement->close();
                        }
                    ?>
                </tbody>
            </table>    
        </div>
        <br/>
        <?php printModal(); ?>
        <?php printFooter(); ?>
        <script>
            $(()=>{
                $("#history_table").DataTable({
                    "order":[]
                });

                $(".btn_detail").on("click",function(){
                    let id = this.getAttribute("value");

                    $.ajax("../php/showPickUpDetail.php",{
                        method:"POST",
                        dataType:"HTML",
                        data:{id:id},
                        success:(data) => {
                            $("#modal-title").text("Pick Up Detail");
                            $(".modal-body").html(data);
                            $(".modal-footer").html("");
                            $("#modal-cancel").attr("data-dismiss","modal");
                            $("#modal").modal();
                        }
                    }); // end callback
                });//end on set listener
            });
            
        </script>
    </body>
</html>
