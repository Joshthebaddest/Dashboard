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
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $username = $row['username'];
    $email = $row['email'];
    $country = $row['country'];
    $gender = $row['gender'];
    $dateOfBirth = $row['date_of_birth'];
    $role = $row['role'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My App</title>
        <link rel="stylesheet" href="../public/css/style.css">

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #DDD;
        }

        tr:hover {background-color: #D6EEEE;}
    </style>
    </head>

    <body class="">
        <div class="flex h-screen bg-gray-100">
            <!-- sidebar -->
            <div class="flex flex-col h-screen w-64 bg-gray-900 text-white">
                <div class="p-4">
                    <h1 class="text-xl font-bold">PBUY</h1>
                </div>
            
                <nav class="flex-1 px-2 py-4">
                    <ul class="space-y-2">
                        <li class="rounded-lg">
                            <a class="flex cursor-pointer items-center w-full px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors" href="./profile.php">Profile</a>
                        </li>
                        <li class="rounded-lg">
                            <a class="flex cursor-pointer items-center w-full px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors" href="./home.php">Dashboard</a>
                        </li>
                    </ul>
                </nav>

                <div class="p-4 border-t border-gray-800">
                    <form action="../controllers/logoutController.php" method="post">
                        <button 
                            class="flex items-center w-full px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors"  
                        >
                            Logout
                        </button>
                    </form>
                </div>
            </div>
            <!-- sidebar end -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Header -->
                <header class="bg-white border-b border-gray-200 h-16">
                    <div class="h-full px-4 py-4 flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <h1 class="text-xl font-semibold text-gray-900">PBUY</h1>
                        </div>

                        <div class="relative space-x-4 group mr-10">
                            <div class="flex items-center space-x-2">
                                <img
                                    src="<?= !empty($row['profileImg']) ? $row['profileImg'] : 'https://ui-avatars.com/api/?name='.urldecode($user); ?>"
                                    alt="<?= $user ?>"
                                    class="w-8 h-8 rounded-full"
                                />
                                <div class="text-sm">
                                    <p class="font-medium text-gray-700">Hi <?=$user?>!</p>
                                </div>
                            </div>

                            <div class="absolute z-50 left-0 p-1 space-y-2 shadow-lg bg-gray-100 rounded-lg border w-full text-center font-bold text-xl opacity-0 group-hover:opacity-100 hover:opacity-100">
                                <ul>
                                    <li>
                                        <a class="block px-4 py-2 bg-gray-200 text-gray-800 text-left rounded-lg text-sm hover:bg-gray-800 hover:text-white" href="./profile.php">Profile</a>
                                    </li>
                                </ul>
                                <div class="font-normal text-sm gap-5 text-center w-full">
                                    <form action="../controllers/logoutController.php" method="post">
                                        <button class=" bg-gray-900 rounded-lg text-white w-full h-8 hover:bg-gray-800" type="submit">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                <!-- Header end -->

                <div class="p-5 px-10 text-center w-full overflow-auto relative">
                    <div class="text-left pb-10 px-10"> 
                        <div>
                            <h3 class="text-center font-bold text-3xl">Profile</h3>
                            <form action="../controllers/fileUploadController.php" method="post" id="imgForm" enctype="multipart/form-data">
                                <div class="flex mb-10">   
                                    <div class="relative w-24 h-24 mr-5">
                                        <!-- Profile Image -->
                                        <img
                                        id="profileImg"
                                        src="<?= !empty($row['profileImg']) ? $row['profileImg'] : 'https://ui-avatars.com/api/?name='.urldecode($user); ?>"
                                        alt=""
                                        class="w-full h-full object-cover rounded-full border border-gray-300"
                                        />

                                        <!-- Overlay -->
                                        <label for="fileInput" class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex flex-col items-center justify-center opacity-0 hover:opacity-100 transition-opacity cursor-pointer">
                                            <svg class="w-6 h-6 text-white mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A2 2 0 0122 9.618V18a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2h5l2-2h4l2 2h5a2 2 0 012 2v3.618a2 2 0 01-2.447 1.894L15 10z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15l-4-4m0 0l4-4m-4 4h16" />
                                            </svg>
                                            <span class="text-white text-xs font-semibold">Change Photo</span>
                                        </label>

                                        <!-- File Input -->
                                        <input id="fileInput" type="file" accept="image/*" name="file" class="hidden">
                                    </div>
                                    <button style="width: fit-content; height: fit-content" class="bg-gray-800 p-2 px-4 text-sm text-white rounded-lg my-auto" type="submit">Update Picture</button>
                                </div>
                            </form>

                            <table>
                                <tbody class="">
                                    <tr class="">
                                        <td class="font-bold">id: </td>
                                        <td><?= htmlspecialchars($userId) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="font-bold">firstname: </td>
                                        <td><?= htmlspecialchars($firstname) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="font-bold">lastname: </td>
                                        <td><?= htmlspecialchars($lastname) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="font-bold">username: </td>
                                        <td><?= htmlspecialchars($username) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="font-bold">email: </td>
                                        <td><?= htmlspecialchars($email) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="font-bold">country: </td>
                                        <td><?= htmlspecialchars($country) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="font-bold">gender: </td>
                                        <td><?= htmlspecialchars($gender) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="font-bold">date of birth: </td>
                                        <td><?= htmlspecialchars($dateOfBirth) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="font-bold">role: </td>
                                        <td><?= htmlspecialchars($role) ?></td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="flex justify-center gap-5 py-10">
                                <a href="./editUser.php?id=<?=$userId?>&type=edit" class='p-2 px-5 bg-gray-600 rounded-lg text-white hover:bg-gray-800'>Edit Profile</a>
                                <a href="./resetPassword.php" class='p-2 px-5 bg-red-600 rounded-lg text-white hover:bg-red-800'>Reset Password</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="../public/js/script.js"></script>
    </body>
</html>