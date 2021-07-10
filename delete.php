<?php
include("db.php");
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $checkid = $conn->prepare("select * from people where id = '" . $id . "'"); // to check id
    $checkid->execute();
    if ($checkid->rowCount() > 0) {
		$insert_query = $conn->prepare("delete from people where id = :id"); //to insert data
        try {
            $conn->beginTransaction();
			$insert_query->bindParam(":id", $id);
            $count = $insert_query->execute();
			
            if ($count> 0) {
                header("Location: index.php?message=Record has been Deleted successfully"); //success data insertion
            } else {
                header("Location: index.php?message=Failed to Delete"); //failure data insertion
            }
            $conn->commit();
        }
        catch (PDOException $e) {
            $dbh->rollback();
            print "Error!: " . $conn->getMessage() . "</br>"; //exception
        }
        
    } else {
        header("Location: index.php?message=Invalid Request");
    }
}
?>