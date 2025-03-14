<?php include("partials/menu.php")?>


<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br />
        <br />
        <?php 
            //get the id of the admin
            $id = $_GET['id'];
            //SQL query to get the details
            $sql = "SELECT * FROM tbl_admin WHERE id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

            // $sql = "SELECT * FROM tbl_admin WHERE id=$id " ;
            // //excute tthe query
            // $res = mysqli_query($conn, $sql);

            if($res==true){
                $count =mysqli_num_rows($res);
                if($count==1){
                    //echo "Admin Available";
                    $row = mysqli_fetch_assoc($res);
                    $full_name = $row['full_name'];
                    $username = $row['username']; 
                }
                else{
                    //redirect to manage-admin
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
               
            }
            
        ?>

        <form method="POST">
            <table class="table-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name?>">
                    </td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username ?>">
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2">
                    <br />
                    <input type="hidden" name="id" value="<?php  echo htmlspecialchars($id,  ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-update"> 

                    </td>
                </tr>

            </table>
        </form>
    </div>
</div>
<?php 
    //check whter the submit button is clicked or not
    if(isset($_POST['submit'])){
        //get all the values from form to update

        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);

        //create sql query to update admin
        $sql = "UPDATE tbl_admin SET 
        full_name = '$full_name',
        username = '$username'
        WHERE id= '$id'

        ";
        

        // Prepare statement
$stmt = mysqli_prepare($conn, $sql);

// Bind parameters
mysqli_stmt_bind_param($stmt, "ssi", $full_name, $username, $id);


// Execute statement
$res = mysqli_stmt_execute($stmt);






if ($res == TRUE) {
  $_SESSION['update']= '<div class="success">Admin Updated Successfully</div>';
  header('location:'.SITEURL.'admin/manage-admin.php');
} else {
  $_SESSION['update']= '<div class="error">Falied to update Admin</div>';
  header('location:'.SITEURL.'admin/manage-admin.php');
}

    }
?>

<?php include("partials/footer.php")?>