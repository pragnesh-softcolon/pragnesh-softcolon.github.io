<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All In One</title>
</head>
<body>
    <form action="" method="POST">
    <table>
        <tr>
            <td>
                <input type="text" name="email" placeholder="Enter Your name">
            </td>
        </tr>
        <tr>
            <td>
                <input type="password" name="password" placeholder="Enter Password">
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" name="submit" value="submit">
            </td>
            <td>
                <button name="show" value="show">
                    Show
                </button>
            </td>
        </tr>
    </table>
    </form>
</body>
<?php
$servername="localhost";
$username="root";//DB user in web
$password="";//Database password
$dbname="pragnesh";//DB name in web
$click = isset($_POST['submit']);
if($click)
{
    $conn = new mysqli($servername, $username, $password);
    if($conn->connect_error)
    {
        $response["success"] = -100;
        $response["message"] = "You are Offline" . $conn->error;
        // echoing JSON response
        echo json_encode($response);
    }
    else
    {
        $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
        $result = $conn->query($sql);
        if($result)
        {
            $conn = new mysqli($servername, $username, $password, $dbname);
            if($conn->connect_error)
            {
                $response["success"] = -404;
                $response["message"] = "Database not connected" . $conn->connect_error;
                // echoing JSON response
                echo json_encode($response);
            }
            else
            {
                $create_table = "CREATE TABLE IF NOT EXISTS Users (ID int(5) AUTO_INCREMENT,
                                EMAIL varchar(255) NOT NULL,
                                PASSWORD varchar(255) NOT NULL,
                                PRIMARY KEY  (ID))";
                $result = $conn->query($create_table);
                if($result) 
                {
                    if(isset($_POST['email']) && isset($_POST['password']))
                    {
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $sql="insert into users(EMAIL,PASSWORD)values('$email','$password')";
                        $result = $conn->query($sql);
                        if($result)
                        {
                            $response["success"] = 1;
                            $response["message"] = "Data Successfully Inserted";
                            // echoing JSON response
                            echo json_encode($response);
                        }
                        else
                        {
                            $response["success"] = 0;
                            $response["message"] = "Oops! An error occurred.";
                            // echoing JSON response
                            echo json_encode($response);
                        }
                    }
                    else
                    {
                        $response["success"] = -1;
                        $response["message"] = "Required field(s) is missing";
                        // echoing JSON response
                        echo json_encode($response);
                    }
                }
                else
                {
                    $response["success"] = -404;
                    $response["message"] = "Database and table not found Offline" . $conn->error;
                    // echoing JSON response
                    echo json_encode($response);
                }
            }
        }
        else
        {
            $response["success"] = 404;
            $response["message"] = "Database not found" . $conn->error;
            // echoing JSON response
            echo json_encode($response);
        }
    }
}
?>
</html>