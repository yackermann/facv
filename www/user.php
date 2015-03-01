<?php
//Check to see if user logged in 
include 'includes/session.php';
require_once 'includes/connect.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>PDO Add User</title>
    </head>
    <body>

    <?php
    $error = '';
    /*-------ADD USER-------*/
    $action = isset( $_POST['action'] ) ? $_POST['action'] : "";
     switch ($action) {
        /*-------DELETE USER-------*/
        case 'create':
            if($_POST['username'] != '' 
                && $_POST['password'] != ''
                && $_POST['password_repeat'] != ''){
                    try{
                        //UAP - Username and Password array
                        $uap = array($_POST['username'],$_POST['password'],$_POST['password_repeat']);
                        //prepare query
                        $sql = "SELECT * FROM login WHERE username = :username";
                        $query = $pdo -> prepare($sql);
                        $query -> bindParam(":username", $_POST["username"], PDO::PARAM_STR );
                        $query -> execute();
                        //store retrieved row to a variable
                        $results = $query -> fetch(PDO::FETCH_ASSOC);
                        if ($results != FALSE && $query -> rowcount() > 0 ){
                            $error = "There is already user with that name.";
                        }elseif ($uap[1] == $uap[2]){
                            $salt = bin2hex(openssl_random_pseudo_bytes(22)); 
                            $hash = crypt($uap[1], "$2a$12$".$salt);
                            $query = "INSERT INTO login 
                            SET id = id, username = :username, password = :password";
                            // Execute the query
                            $stmt = $pdo->prepare($query);
                            $stmt->bindParam(":username", $uap[0], PDO::PARAM_STR );
                            $stmt->bindParam(":password", $hash, PDO::PARAM_STR );
                            $stmt->execute();
                            $error = "New user has been added successfully.";
                        }else{
                            $error = "Passwords does not match!";
                        }
                    }catch(PDOException $exception){ //to handle error
                            $error = "Error: " . $exception->getMessage() . '</p>';
                    }
            }else{$error = 'Please fill in all fields.';}
            break;

        case 'update':
            if($_POST['password'] != '' && $_POST['password_repeat'] != ''){
                try{
                    //passwords
                    $pass = array($_POST['password'],$_POST['password_repeat']);
                    //prepare query
                    $sql = "SELECT * FROM login WHERE id = :id";
                    $query = $pdo -> prepare($sql);
                    $query -> bindParam(":id", $_GET["e"], PDO::PARAM_STR );
                    $query -> execute();
                    //store retrieved row to a variable
                    $results = $query -> fetch(PDO::FETCH_ASSOC);
                    if ($results != FALSE && $query -> rowcount() > 0){
                        if($pass[0] == $pass[1]){
                            $salt = bin2hex(openssl_random_pseudo_bytes(22)); 
                            $hash = crypt($pass[1], "$2a$12$".$salt);
                            $query = "UPDATE login SET username = username, password = :password WHERE id = :id";
                            // Execute the query
                            $stmt = $pdo->prepare($query);
                            $stmt -> bindParam(":password", $hash, PDO::PARAM_STR );
                            $stmt -> bindParam(":id", $_GET["e"], PDO::PARAM_STR );
                            $stmt->execute();
                            $error = "Password has been updated successfully!";
                        }else{$error = "Passwords does not match!";}
                    }else{
                        $error = "Unexpected error!";
                    }
                }catch(PDOException $exception){ //to handle error
                        $error = "Error: " . $exception->getMessage() . '</p>';
                }   
            }else{$error = 'Please fill in all fields.';}
            break;
    }

    $get_action = isset($_GET['action']) ? $_GET['action']: "";
    switch ($get_action) {
        /*-------DELETE USER-------*/
        case 'delete':
           try {
                /*Checks if you are the only user*/
                $sql = "SELECT * FROM login";
                $query = $pdo -> prepare($sql);
                $query -> execute();
                $results = $query -> fetch(PDO::FETCH_ASSOC);
                if ($results != FALSE && $query -> rowcount() > 1 ){
                    /*Removes user*/
                    $sql = "DELETE FROM login WHERE id = :id";
                    $query = $pdo -> prepare($sql);
                    $query -> bindParam(':id', $_GET['id']);
                    $query -> execute();
                    $error = "User was deleted successfully.";
                }else{
                    $error = 'You can not delete the only user!';
                }
            }catch(PDOException $exception){ //to handle error
                    $error = "Error: " . $exception->getMessage();
            }
            break;
    }

    if(!isset($_GET['e'])){
    ?>
    <!--we have our html form here where user information will be entered-->
        <form action='#' method='post' border='0'>
            <table>
                <tr><td><h4><center>Add new user.</center></h4></td></tr>
                <tr>
                    <td>Username</td>
                    <td><input type='text' name='username' placeholder='Username' /></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>
                        <div class="control-group">
                            <input type="password" name='password' id="mypass" placeholder="Password"/>
                            <input type="password" name="password_repeat"id="password_repeat" placeholder="And again"/>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='hidden' value='' />
                        <input type='hidden' name='action' value='create' />
                        <?php if(isset($error)){echo '<p><b><u>'.$error.'</u></b></p>';} ?>
                        <input type='submit' value='Add user' />
                        
                         || <a href='admin.php'>Back to admin</a>
                    </td>
                </tr>
            </table>
        </form>
    <?php }else{ ?>
         <form action='' method='post' border='0'>
            <table>
                <tr><td><h4><center>Edit user</center></h4></td></tr>
                <tr>
                    <td>New Password</td>
                    <td>
                        <div class="control-group">
                            <input type="password" name='password' id="mypass" placeholder="Password"/>
                            <input type="password" name="password_repeat"id="password_repeat" placeholder="And again"/>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='hidden' name='id' value='<?php if (isset($_GET['e'])){echo $_GET['e'];}?>' />
                        <input type='hidden' value='' />
                        <input type='hidden' name='action' value='update' />
                        <?php if(isset($error)){echo '<p><b><u>'.$error.'</u></b></p>';} ?>
                        <input type='submit' value='Save' />
                        
                         || <a href='user.php'>Back to users</a>
                    </td>
                </tr>
            </table>
        </form>
    <? }?>
        <hr>
        <?php
            $query = "SELECT id, username, password FROM login";
            $stmt = $pdo->prepare( $query );
            $stmt->execute();

            //this is how to get number of rows returned
            $num = $stmt->rowCount();
            echo "".'<br />';

            if($num>0){ //check if more than 0 record found

                echo "<table border='1'>";//start table
                
                    //creating our table heading
                    echo "<tr>";
                        echo "<th>Username</th>";
                        echo "<th>Password</th>";
                        echo "<th>Action</th>";
                    echo "</tr>";
                    
                    //retrieve our table contents
                    //fetch() is faster than fetchAll()
                    //http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        //extract row
                        //this will make $row['firstname'] to
                        //just $firstname only
                        extract($row);
                        
                        //creating new table row per record
                        echo "<tr>";
                            echo "<td>{$username}</td>";
                            echo "<td>********</td>";
                            echo "<td>";
                                //we will use this links on next part of this post
                                 echo "<a href='user.php?e={$id}'>Edit</a>";
                                echo " / ";
                                //we will use this links on next part of this post
                                echo "<a href='#' onclick='delete_user({$id});'>Delete</a>";
                            echo "</td>";
                        echo "</tr>";
                    }
                    
                echo "</table>";//end table
                
            }else{ //if no records found
                echo "No records found.";
            }
        ?> 
    <script type='text/javascript'>
    
        function delete_user( id ){
        var answer = confirm('Are you sure?');
        if (answer){ //if user clicked ok
            //redirect to url with action as delete and id to the record to be deleted
            window.location = 'user.php?action=delete&id=' + id;
        } 
    }
</script>
    </body>
</html>