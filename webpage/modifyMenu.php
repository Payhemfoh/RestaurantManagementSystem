<?php
    $id = $_POST['id'];

    //database connection
    $connect = new mysqli("localhost","root","","rms_database");

    //check connection
    if($connect->connect_error){
        die("Connection error : $connect->connect_errno : $connect->connect_error");
    }

    if($statement = $connect->prepare("SELECT * FROM menu WHERE menu_id=? LIMIT 1")){
        $statement->bind_param("d",$id);
        $statement->execute();
        $result = $statement->get_result();

        while($row = $result->fetch_array()){
            echo "<form>
            <table class='table'>
                <thead class='thead-light'>
                    <tr>
                        <th><font size='6'>Image</font></th>					
                        <th><font size='6'>Information</font></th>
                    </tr>	
                </thead>
                <tbody>
                    <tr>				
                        <td>
                            <div class='form-group'>
                                <p>Current Picture:</p>
                                <img src='".$row['menu_picture']."' class='img-thumbnail'><br><br>
                                <p>New Picture:</p>
                                <div class='form-group inputDnD'>
                                    <label class='sr-only' for='inputFile'>File Upload</label>
                                    <input type='file' id='dropzone' name='newImg' accept='image/*' class='form-control-file text-primary font-weight-bold'
                                if='newImg' data-title = 'Click Here or Drag and Drop to Upload File'>
                                </div>           
                            </div>
                        </td>
                        <td>
                            <div class='form-group'>
                                <label for='name'>Name:</label>
                                <input type='text' class='form-control' name='name' value='".$row['menu_name']."'>
                            </div>
        
                            <div class='form-group'>
                                <label for='category'>Category:</label>
                                <select id='category_input' class='form-control' name='category'>";
                            
        
                                if($statement2 = $connect->prepare("SELECT * FROM menu_category")){
                                    $statement2->execute();
                                    $result2 = $statement2->get_result();
        
                                    while($row2 = $result2->fetch_array()){
                                        if($row2['category_id'] == $row['category_id']){
                                            echo '<option value='.$row2['category_id'].' selected>'.$row2['category_name'].'</option>';
                                        }else{
                                            echo '<option value='.$row2['category_id'].'>'.$row2['category_name'].'</option>';
                                        }
                                    }

                                    $statement2->close();
                                }else{
                                    die("Failed to prepare SQL statement.");
                                }
                                
                            
                    printf("</select>
                                <div id='category-feedback'></div>
                            </div>
        
                            <div class='form-group'>
                                <label for='name'>Ingredients:</label>
                                <textarea class='form-control' 
                                name='ingredients'>Chicken,Rice,Cucumber,Soy Sauce,Cooking Oil, Chili Sauce</textarea>
                            </div>
        
                            <div class='form-group'>
                                <label for='price'>Price(RM):</label>
                                <input type='number' step='0.01' class='form-control' name='price' value='%.2f'>
                            </div>
                            
                            <div class='form-group'>
                                <label for='description'>Description:</label>
                                <textarea class='form-control' name='description'>%s</textarea>
                            </div>						
                        </td>
                    </tr>
                </tbody>        
            </table>	
            <button id='modal-submit' class='btn btn-block btn-primaryLight btn-primary' value='%d'>Modify</button>
            <button id='modal-cancel' class='btn btn-block btn-primaryLight btn-primary'>Cancel</button>		
        </form>",$row['menu_price'],$row['menu_description'],$row['menu_id']);
        }
        $statement->close();
    }else{
        die("Failed to prepare SQL statement.");
    }
    $connect->close();


?>