<?php
$update=false;
$delete=false;
$insert= false; 

$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";


$conn = mysqli_connect($servername, $username, $password,$database);

if (!$conn){

    die("sorry we failed to connect to database".mysqli_connect_error());
}

if(isset($_GET['delete'])){
    $sno =$_GET['delete'];
    $delete= true;
    $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
    $result = mysqli_query($conn,$sql);

}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
if (isset($_POST['snoEdit'])){
        //update the record
        
      $sno = $_POST["snoEdit"];
      $title = $_POST["titleEdit"];
      $description= $_POST["descriptionEdit"];


    $sql = "UPDATE `notes` SET `title` = '$title',`description` = '$description' WHERE `notes`.`sno` = $sno";
    $result = mysqli_query($conn,$sql);
    if($result){
        $update = true;
    }
else{
    echo "We could not update the record successfully";
}
}
else{
    $title = $_POST["title"];
    $description= $_POST["description"];


    $sql = "INSERT INTO `notes` ( `title`, `description`) VALUES ( '$title' , '$description')";
    $result = mysqli_query($conn,$sql);

        //check if the database created

    if($result){
       $insert= true;
    }
    else{
        echo "The record has not been inserted successfully because of this error !".mysqli_error($conn);
    }
}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    
    <title>crud</title>
</head>

<body>
    <!-- edit modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
Edit Modal
</button> -->

    <!-- edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/crud/index.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title:</label>
                            <input type="title" class="form-control" id="titleEdit" name="titleEdit"
                                aria-describedby="emailHelp" />
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Title Description:</label>
                            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit"
                                rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">crud</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link " aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact us</a>
                    </li>
                </ul>
                <form class="d-flex">

                </form>
            </div>
        </div>
    </nav>

    <?php
    if($insert){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your Note has been inserted successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>
    <div class="container mt-4">
        <h2>Add Notes</h2>
        <form action="/crud/index.php" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" />
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Title Description:</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>

    <div class="container mt-4">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.no</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php

        $sql = "SELECT * FROM `notes`";
        $result = mysqli_query($conn,$sql);

        $num=mysqli_num_rows($result);
        $sno = 0;
        while ($row=mysqli_fetch_assoc($result)){
            $sno = $sno + 1;
            echo "<tr>
            <th scope='row'>". $sno . "</th>
            <td>". $row['title'] . "</td>
            <td>". $row['description'] . "</td>
            <td> <button class='edit btn btn-sm btn-primary'id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button> </td>
            </tr>";
            
            }
            
        ?>


                </tr>
            </tbody>
        </table>
    </div>
    <hr>

    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>

    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit ",)
                tr = e.target.parentNode.parentNode
                title = tr.getElementsByTagName("td")[0].innerText;
                description = tr.getElementsByTagName("td")[1].innerText;
                console.log(title, description);
                titleEdit.value = title;
                descriptionEdit.value = description;
                snoEdit.value = e.target.id
                $('#editModal').modal('toggle');
            })
        })

        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit ",)
                sno=e.target.id.substr(1);
              
                if (confirm("Confirm to delete the note")){
                    console.log("yes");
                    window.location =`/crud/index.php/?delete= ${sno}`;
                }
                else{
                    console.log("No");
                }
            })
        })
    </script>

</body>

</html>