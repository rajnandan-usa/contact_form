<?php
//db connection
$server = "localhost";
$username = "root";
$password = "";
$db = "contact_form";

$conn = new mysqli($server, $username, $password, $db);

if($conn->connect_error){
    die("Connection faild:" . $conn->connect_error);
}else{
    echo "Connection success";
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $fullname = htmlspecialchars($_POST['fullname']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);
//email and phone validation 
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "Invalid Email";
    }elseif(!preg_match('/^[0-9]{10}$/', $phone)){
        $error = "invalid phone";
    }else{
//insert query
        $query = $conn->prepare("INSERT INTO contact_form (fullname, phone, email, subject, message)
        VALUES(?, ?, ?, ?, ?)");
        $query->bind_param("sssss", $fullname, $phone, $email, $subject, $message);
if($query->execute()){
    $success = "Form Submit successfully";
}
$query->close();

    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
</head>
<body>
    <h1>Contact Form</h1>
<!---message-->
    <?php if(!empty($error)): ?>
   <p> <?php echo $error; ?></p>
  <?php elseif(!empty($success)): ?>
    <p> <?php echo $success; ?> </p>
    <?php endif; ?>
  <!---Contact form ---->
    <form method="post">
         
    <input type="text" name="fullname" placeholder="Fullname">
    <input type="number" name="phone" placeholder="phone">
    <input type="email" name="email" id="" placeholder="Email">
    <input type="text" name="subject" placeholder="subject">
    <textarea name="message" id=""></textarea>
    <button type="submit">Submit</button>
    <!-- <input type="button" value="submit" name="submit"> -->
    </form>

</body>
</html>



