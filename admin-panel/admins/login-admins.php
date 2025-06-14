<?php 
require "../layouts/header.php";    
require "../../config/config.php";    



if (isset($_SESSION['admin_name'])) {
    header("Location: https://maisreyneang.com/sreyneang/anxiety-coffee/admin-panel/");
    exit;
}

if (isset($_POST['submit'])) {

    if (empty($_POST['email']) || empty($_POST['password'])) {
        echo "<script>alert('One or more inputs are empty');</script>";
    } else { 

        $email = $_POST['email'];
        $password = $_POST['password'];

        // Use prepared statement for security
        $login = $conn->prepare("SELECT * FROM admins WHERE email = :email");
        $login->bindParam(':email', $email);
        $login->execute();

        $fetch = $login->fetch(PDO::FETCH_ASSOC);

        if ($fetch) {
            if (password_verify($password, $fetch['password'])) {
                // Set session variables
                $_SESSION['admin_name'] = $fetch['adminname'];
                $_SESSION['email'] = $fetch['email'];
                $_SESSION['admin_id'] = $fetch['id'];

                // ✅ Redirect to admin dashboard
                header("Location: https://maisreyneang.com/sreyneang/anxiety-coffee/admin-panel/");
                exit;
            } else {
                echo "<script>alert('Email or password is incorrect');</script>";
            }
        } else {
            echo "<script>alert('Email or password is incorrect');</script>";
        }
    }
}
?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mt-5">Login</h5>
                <form method="POST" action="login-admins.php" class="p-auto">
                    <div class="form-outline mb-4">
                        <input type="email" name="email" class="form-control" placeholder="Email" required />
                    </div>

                    <div class="form-outline mb-4">
                        <input type="password" name="password" class="form-control" placeholder="Password" required />
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>
