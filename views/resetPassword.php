<?php   
    include('../models/users.php');
    require('../middleware/protected.php');

    $sql = "SELECT * FROM $users_table WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $userId = $row['id'];
    $username = $row['username'];
    $email = $row['email'];
    $country = $row['country'];
    $gender = $row['gender'];
    $country = $row['country'];
    $passwordHash = $row['password_hash'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $password = test_input($_POST["password"]);
        $newPassword = test_input($_POST["newPassword"]);
        $confirmPassword = test_input($_POST["confirmPassword"]);
        $verify = password_verify($password, $passwordHash);
        if(empty($password) && !$verify){
            $errors["error"] = "Invalid Password! please enter a correct password";
        }
        validate_form($newPassword, $confirmPassword);
        if(!empty($password) && $password === $newPassword){
            $errors["error"] = "Please enter a new Password";
        }
        if (empty($errors)) {
            $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);

            include('../models/users.php');

            $sql = "UPDATE $users_table SET password_hash = ? WHERE ID = ?";
            $result = $conn->prepare($sql);
            $result -> bind_param("si", $hashed_password, $userId);
            if ($result->execute()) {
                echo "New record updated successfully";
                header('Location: ../views/profile.php');
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            // print_r($errors); // to debug
        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function validate_form($newPassword, $confirmPassword) {
        global $errors;
        if (empty($newPassword)) {
            $errors["error"] = "Password is required";
        } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&]).{8,}$/', $newPassword)) {
            $errors["error"] = "Password must have uppercase, lowercase, number, special character, and be 8+ chars long.";
        }

        if (empty($confirmPassword)) {
            $errors["error"] = "Please confirm your password";
        } elseif ($confirmPassword !== $newPassword) {
            $errors["error"] = "Passwords do not match";
        }
    }
?>

<div>
    <h3 class="text-center font-bold text-2xl">Reset Password</h3>

    <div class="text-center">
        <?php if (!empty($errors["error"])): ?>
            <span class="text-red-600 text-xs"><?= htmlspecialchars($errors["error"]) ?></span>
        <?php endif; ?>
    </div>

    <div style="width: 500px" class="space-y-4 py-5 mx-auto">
        <form action="" method="POST">
            <div class="rounded-md shadow-sm space-y-4">    
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Password
                    </label>
                    <Input
                        type="text"
                        name="password"
                        class="border rounded-lg w-full outline-none p-2" 
                    />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        New Password
                    </label>
                    <Input
                        type="text"
                        name="newPassword"
                        class="border rounded-lg w-full outline-none p-2" 
                    />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Confirm Password
                    </label>
                    <Input
                        type="text"
                        name="confirmPassword"
                        class="border rounded-lg w-full outline-none p-2" 
                    />
                </div>
            </div>
        

            <div class="p-10 px-2 w-full flex gap-5">
                <button type="submit" class="font-medium text-center w-full rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 cursor-pointer bg-gray-900 text-white hover:bg-indigo-700 focus:ring-indigo-500 px-4 py-2 text-base">
                    Reset
                </button>
                <a href="./profile.php" type="submit" class="font-medium text-center w-full rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 cursor-pointer bg-red-600 text-white hover:bg-gray-700 focus:ring-indigo-500 px-4 py-2 text-base">
                    Cancel
                </a>
            </div>
        </form>
    </div>

</div>
            