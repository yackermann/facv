<?php
//Check to see if user logged in 
include 'includes/session.php';
//include database connection
include 'includes/connect.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Admin Page</title>
        
    </head>
<body>

<!-- SESSION_ID = <?php echo $_SESSION['id']; ?> -->
<?php
//isset($_POST['action'] checks to see if when the form was 
// submitted that the parameter action was passed, if so $action will 
// contain the value that has been passed otherwise set $action to Null ""
$action = isset($_GET['action']) ? $_GET['action']: "";

if($action=='delete'){ //if the user clicked ok, run our delete query
    try {
    
        $query = "DELETE FROM activities WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $_GET['id']);
        
        $result = $stmt->execute();
        echo "<div>Record was deleted.</div>";
        
    }catch(PDOException $exception){ //to handle error
        echo "Error: " . $exception->getMessage();
    }
    
}
   
//select all data 
$query = "SELECT id, activity, theme, description, website, image, tourguide_id FROM activities";
$stmt = $pdo->prepare( $query );
$stmt->execute();

//this is how to get number of rows returned
$num = $stmt->rowCount();
echo "".'<br />';

echo "<a href='bureau.php'>Add Record</a>"." || "."<a href='user.php'>Users</a>"." || "."<a href='login.php?u=1'>Logout</a>";;
if($num>0){ //check if more than 0 record found

    echo "<table border='1'>";//start table
    
        //creating our table heading
        echo "<tr>";
            echo "<th>Activity</th>";
            echo "<th>Theme</th>";
            echo "<th>Description</th>";
            echo "<th>Website</th>";
            echo "<th>Image</th>";
             echo "<th>Tourguide_id</th>";
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
                echo "<td>{$activity}</td>";
                echo "<td>{$theme}</td>";
                echo "<td>{$description}</td>";
                echo "<td>{$website}</td>";
                echo "<td>{$image}</td>";
                 echo "<td>{$tourguide_id}</td>";
                echo "<td>";
                    //we will use this links on next part of this post
                     echo "<a href='bureau.php?e={$id}'>Edit</a>";
                    echo " / ";
                    //we will use this links on next part of this post
                    echo "<a href='#' onclick='delete_record( {$id} );'>Delete</a>";
                echo "</td>";
            echo "</tr>";
        }
        
    echo "</table>";//end table
    
}else{ //if no records found
    echo "No records found.";
}

?>

<script type='text/javascript'>
    
    function delete_record( id ){
        var answer = confirm('Are you sure?');
        if (answer){ //if user clicked ok
            //redirect to url with action as delete and id to the record to be deleted
            window.location = 'admin.php?action=delete&id=' + id;
        } 
    }
</script>

</body>
</html>