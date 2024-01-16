<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;1,800&display=swap" rel="stylesheet">
    <title>Student management</title>


</head>

<body dir="rti">
    <?php
    //Connect with the database
    

    $host = 'localhost';
    $user = "root";
    $pass = "";
    $db = "students";
    $con = mysqli_connect($host, $user, $pass, $db, );
    $res = mysqli_query($con, "select * from student");
    //button variable
    $id = "";
    $name = "";
    $address = "";

    if (isset($_POST['id'])) {
        $name = $_POST['id'];
    }
    ;
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
    }
    ;
    if (isset($_POST['address'])) {
        $name = $_POST['address'];
    }
    ;
    $sqls = '';
    if (isset($_POST['add'])) {
        //mysqli_real_escape_string
        $id = mysqli_real_escape_string($con, $_POST['id']);
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $address = mysqli_real_escape_string($con, $_POST['address']);

        $sql = "INSERT INTO student (id, name, address) VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($con, $sql);


        mysqli_stmt_bind_param($stmt, "sss", $id, $name, $address);

        if (mysqli_stmt_execute($stmt)) {
            header("location: home.php");
        } else {
            echo "Error adding student" . mysqli_error($con);
        }

        mysqli_stmt_close($stmt);
    }

    if (isset($_POST['del'])) {
        $name = mysqli_real_escape_string($con, $_POST['name']);

        // placeholders
        $sql = "DELETE FROM student WHERE name = ?";

        $stmt = mysqli_prepare($con, $sql);

        mysqli_stmt_bind_param($stmt, "s", $name);

        if (mysqli_stmt_execute($stmt)) {
            header("location: home.php");
        } else {
            echo "Error deleting student" . mysqli_error($con);
        }
        mysqli_stmt_close($stmt);
    }


    ?>
    <div id="mother">
        <form method="POST">
            <!-- control Board-->
            <aside>
                <div id="div1">
                    <img src="https://dapulse-res.cloudinary.com/image/upload/c_scale,h_580/v1614847731/remote_mondaycom_static/uploads/NaamaGros/education/edu-student-4.png"
                        width="200px" alt="Website logo">
                    <h3>Administration panel:</h3>
                    <label>Student number:</label><br>
                    <input type="text" name="id" id="id"><br>
                    <label>Student's name:</label><br>
                    <input type="text" name="name" id="name"><br>
                    <label>Student address:</label><br>
                    <input type="text" name="address" id="address"><br><br>
                    <button name="add" id="add">Add a student</button>
                    <button name="del" id="del">Delete student</button>
                </div>
            </aside>
            <main id="main">
                <!--Show student data-->
                <table id="tbl">
                    <tr>
                        <th>Student number</th>
                        <th>Student's name</th>
                        <th>Student address</th>

                    </tr>
                    <?php
                    while ($row = mysqli_fetch_array($res)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>


            </main>
        </form>
    </div>
</body>

</html>