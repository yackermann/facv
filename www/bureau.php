<?php
//Check to see if user logged in 
include 'includes/session.php';
require_once 'includes/connect.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>PDO Create Record  </title>
          <!-- code adapted from http://codeofaninja.com -->
    </head>
<body>

<?php
    /*-------INSERT TO DB-------*/
    $action = isset( $_POST['action'] ) ? $_POST['action'] : "";
    switch ($action) {
        /*-----If Updating-----*/
        case 'update':
            try{
           
                //write query
                $query = "UPDATE activities
                            SET activity = :activity, theme = :theme, description = :description, website  = :website, image = :image, tourguide_id = :tourguide_id
                            where id = :id";
                //prepare query for excecution and bind the parameters
            include 'includes/prepare_bind.php';
                $stmt->bindParam(':id',$_POST['id']);
               
                // Execute the query
                $stmt->execute();
               
                echo "<p class='success'>Successful editing!</p>";
           
            }catch(PDOException $exception){ //to handle error
                echo '<p class="warning">'."Error: " . $exception->getMessage() . '</p>';
            }
            break;

        /*-----If Creating-----*/
        case 'create':
            try{
           
                //write query  
                $query = "INSERT INTO activities 
                SET activity = :activity, theme = :theme, description = :description, website  = :website, image = :image, tourguide_id = :tourguide_id";
                //prepare query for excecution and bind the parameters
                include 'includes/prepare_bind.php';
                
                // Execute the query
                $stmt->execute();
               
                echo "<p class='success'>New record added</p>";
           
            }catch(PDOException $exception){ //to handle error
                    echo '<p class="warning">'."Error: " . $exception->getMessage() . '</p>';
            }
            break;
        
    }

    /*-------RETREAVE FROM DB-------*/
    if (isset($_GET['e'])){
        try {
            //prepare query
            $query = "select id, activity, theme, description, website, image, tourguide_id  from activities where id = :id limit 0,1";
            $stmt = $pdo->prepare( $query );
            $stmt->bindParam(':id', $_REQUEST['id']);
            //execute our query
            $stmt->execute();
           
            //store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
           
            //values to fill up our form
            $id = $row['id'];
            $activity = $row['activity'];
            $theme = $row['theme'];
            $description = $row['description'];
            $website = $row['website'];
            $image = $row['image'];
            $tourguide_id = $row['tourguide_id'];
        }catch(PDOException $exception){ //to handle error
            echo "Error: " . $exception->getMessage();
        }
    }

?>
<!--we have our html form here where user information will be entered-->
<form action='#' method='post' border='0'>
    <table>
        <tr>
            <td>Activity</td>
            <td><input type='text' name='activity' value='<?php if(isset($activity)){ echo $activity;}  ?>' /></td>
        </tr>
        <tr>
            <td>Theme</td>
            <td><input type='text' name='theme' value='<?php if(isset($theme)){echo $theme;} ?>' /></td>
        </tr>
        <tr>
            <td>Description</td>
                <td ><textarea name='description' rows ='10' cols ='100' wrap = 'virtual'><?php if(isset($description)){echo $description;}  ?></textarea>
           <!-- textarea gives a multilined (10 rows) area to display the field -->
        </tr>
        <tr>
            <td>Website</td>
            <td><input type='text' name='website'  value='<?php if(isset($website)){echo $website;}  ?>' /></td>
        <tr>
            <td>Image Name</td>
            <td><input type='text' name='image'  value='<?php if(isset($image)){echo $image;}  ?>' /></td>
        </tr>
        <tr>
            <td>Tourguide_id</td>
            <td><input type='text' name='tourguide_id'  value='<?php if(isset($tourguide_id)){echo $tourguide_id;}  ?>' /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type='hidden' name='id' value='<?php if (isset($_GET['e'])){echo $_GET['e'];}?>' />
                <input type='hidden' name='action' value='<?php  if (isset($_GET['e'])){echo 'update';}else{echo 'create';} ?>' />
                <input type='submit' value='Save' />
               
                 || <a href='admin.php'>Back to admin</a>
            </td>
        </tr>
    </table>
</form>
</body>
</html>