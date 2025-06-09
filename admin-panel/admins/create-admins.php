<?php 
require "../layouts/header.php";    
require "../../config/config.php"; 

session_start();

if (!isset($_SESSION['admin_name'])) {
    header("Location: ".ADMINURL."/admins/login-admins.php");
    exit;
}

if (isset($_POST['submit'])) {

    if (empty($_POST['adminname']) || empty($_POST['email']) || empty($_POST['password'])) {
        echo "<script>alert('One or more inputs are empty');</script>";
    } else {
        $adminname = $_POST['adminname'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $insert = $conn->prepare("INSERT INTO admins (adminname, email, password)
                                  VALUES (:adminname, :email, :password)");

        $insert->execute([
            ":adminname" => $adminname,
            ":email" => $email,
            ":password" => $password
        ]);

        header("Location: admins.php");  // Adjust path if necessary
        exit;
    }
}
?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-5 d-inline">Create Admins</h5>
                <form method="POST" action="create-admins.php" enctype="multipart/form-data">
                    <div class="form-outline mb-4 mt-4">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" required />
                    </div>

                    <div class="form-outline mb-4">
                        <input type="text" name="adminname" id="adminname" class="form-control" placeholder="Username" required />
                    </div>

                    <div class="form-outline mb-4">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required />
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>
