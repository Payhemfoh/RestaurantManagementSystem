<!DOCTYPE html>
<html lang="en">
    <?php
        session_start();

        if($_SESSION['sess_position'] == "customer" || $_SESSION['sess_position'] == NULL){
            header('Refresh: 0; URL=../webpage/homepage.php');
        }
    ?>
    <head>
        <title>RMS | Menu Management Module</title>
        <?php 
            require("../php/pageFragment.php");
            printHeadInclude();
        ?>
    </head>

    <body class="bg-light">
        <?php
            printHeader(basename(__FILE__));
        ?>
        <br/>
        <div id="content" class="container-fluid py-5 bg-light rounded">
            <div class="h2 text-center">Menu Management Module</div>
            <br><br>
            <button class="btn btn-block btn-primary btn_add">Add New Menu</button><br>
            <table id="table" class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Category</th>
                        <th scope="col">Price</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
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

                        if($statement = $connect->prepare("SELECT * FROM menu m,menu_category c WHERE m.category_id = c.category_id;")){
                            $statement->execute();
                            $result = $statement->get_result();

                            while($row = $result->fetch_array()){
                                printf( '<tr>
                                        <td scope="row"><img src="%s" class="img-thumbnail"></td>
                                        <td>%s</td>
                                        <td>%s</td>
                                        <td>%s</td>
                                        <td>RM%.2f</td>
                                        <td><button class="btn btn-primaryLight btn-primary btn_edit" value="%d">Edit</button></td>
                                        <td><button class="btn btn-primaryLight btn-primary btn_delete" value="%d">Delete</button></td>
                                    </tr>',
                                    $row['menu_picture'],
                                    $row['menu_name'],
                                    $row['menu_description'],
                                    $row['category_name'],
                                    $row['menu_price'],
                                    $row['menu_id'],
                                    $row['menu_id']);
                            }

                            $statement->close();
                        }else{
                            die("Failed to prepare SQL statement.");
                        }
                        $connect->close();
                    ?>
                    

                    <tr>
                        <td scope="row"><img src="../images/MenuManagement/laksa.jpg" class="img-thumbnail"></th>
                        <td>Laksa</td>
                        <td>Delicious Penang Laksa</td>
                        <td>Noodles,Shrimp Paste, Fish, Vegetables, Chili, Onion, Ginger</td>
                        <td>RM7.00</td>
                        <td><a class="btn btn-primaryLight btn-primary btn_edit">Edit</a></td>
                        <td><a class="btn btn-primaryLight btn-primary btn_delete">Delete</a></td>
                    </tr>

                    <tr>
                        <td scope="row"><img src="../images/MenuManagement/eggsandwich.jpg" class="img-thumbnail"></th>
                        <td>Egg Sandwich</td>
                        <td>Delicious sandwich</td>
                        <td>Egg, Bread, Butter, Mayonese, Vegetables</td>
                        <td>RM5.00</td>
                        <td><a class="btn btn-primaryLight btn-primary btn_edit">Edit</a></td>
                        <td><a class="btn btn-primaryLight btn-primary btn_delete">Delete</a></td>
                    </tr>

                    <tr>
                        <td scope="row"><img src="../images/MenuManagement/duckrice.jpg" class="img-thumbnail"></th>
                        <td>Duck Rice</td>
                        <td>Delicious duck rice</td>
                        <td>Duck, Rice, Soy Sauce, Vegetables, Cooking Oil</td>
                        <td>RM7.00</td>
                        <td><a class="btn btn-primaryLight btn-primary btn_edit">Edit</a></td>
                        <td><a class="btn btn-primaryLight btn-primary btn_delete">Delete</a></td>
                    </tr>

                    <tr>
                        <td scope="row"><img src="../images/MenuManagement/chickenchop.jpg" class="img-thumbnail"></th>
                        <td>BBQ Chicken Chop</td>
                        <td>Delicious chicken chop with sweet bbq sauces</td>
                        <td>Chicken, Fries, Salad, BBQ Sauce</td>
                        <td>RM12.00</td>
                        <td><a class="btn btn-primaryLight btn-primary btn_edit">Edit</a></td>
                        <td><a class="btn btn-primaryLight btn-primary btn_delete">Delete</a></td>
                    </tr>

                    <tr>
                        <td scope="row"><img src="../images/MenuManagement/fishchips.jpg" class="img-thumbnail"></th>
                        <td>Fish &amp; Chips</td>
                        <td>Delicious fried fish with tatar sauce</td>
                        <td>Fish, Fries, Salad, Tatar Sauce</td>
                        <td>RM12.00</td>
                        <td><a class="btn btn-primaryLight btn-primary btn_edit">Edit</a></td>
                        <td><a class="btn btn-primaryLight btn-primary btn_delete">Delete</a></td>
                    </tr>

                    <tr>
                        <td scope="row"><img src="../images/MenuManagement/grillchicken.jpg" class="img-thumbnail"></th>
                        <td>Grill Chicken Chop</td>
                        <td>Delicious chicken chop which is grilled and mix with the special made black pepper sauce.</td>
                        <td>Grill Chicken, Fries, Salad, Black Pepper Sauce</td>
                        <td>RM14.00</td>
                        <td><a class="btn btn-primaryLight btn-primary btn_edit">Edit</a></td>
                        <td><a class="btn btn-primaryLight btn-primary btn_delete">Delete</a></td>
                    </tr>

                    <tr>
                        <td scope="row"><img src="../images/MenuManagement/lambchop.jpg" class="img-thumbnail"></th>
                        <td>Lamb Chop</td>
                        <td>Delicious grill lamb chop served with black pepper sauce.</td>
                        <td>Lamb, Fries, Salad, Black Pepper Sauce</td>
                        <td>RM16.00</td>
                        <td><a class="btn btn-primaryLight btn-primary btn_edit">Edit</a></td>
                        <td><a class="btn btn-primaryLight btn-primary btn_delete">Delete</a></td>
                    </tr>

                    <tr>
                        <td scope="row"><img src="../images/MenuManagement/nasilemak.jpg" class="img-thumbnail"></th>
                        <td>Nasi Lemak</td>
                        <td>Localize nasi lemak, the best choice for those who want to enjoy the Malaysia local style dishes.</td>
                        <td>Coconut Milk, Rice, Egg, Anchovies, Cucumber, Sambal, Chicken, Peanuts</td>
                        <td>RM8.00</td>
                        <td><a class="btn btn-primaryLight btn-primary btn_edit">Edit</a></td>
                        <td><a class="btn btn-primaryLight btn-primary btn_delete">Delete</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br/>

        <?php printModal(); ?>
        <?php printFooter(); ?>

        <script type="module" src="../javascript/menuManagementModule_script.js"></script>
    </body>
</html>
