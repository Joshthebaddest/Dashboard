<?php   
    require_once __DIR__ . '/../middleware/protected.php';
    include __DIR__ . '/../models/users.php';

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

<div>
    <h3 class="text-center font-bold text-3xl">Settings</h3>
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
        <a href="./editUser.php?user=<?=$username?>&type=edit" class='p-2 px-5 bg-gray-600 rounded-lg text-white hover:bg-gray-800'>Edit Profile</a>
        <a href="./resetPassword.php" class='p-2 px-5 bg-red-600 rounded-lg text-white hover:bg-red-800'>Reset Password</a>
    </div>
</div>
                    