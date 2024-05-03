<?php
include("./ini.php");
include(__ROOT__. "/codePart/header.php");

if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_naissance = $_POST['date_naissance'];
    $adresse = $_POST['adresse'];
    $bio = $_POST['bio']; // 接收表单中的个人简介

    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // 更新密码前先进行加密
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 更新用户信息，包括个人简介
    $stmt = $dbConn->db->prepare("UPDATE user SET mdp = ?, nom = ?, prenom = ?, date_naissance = ?, adresse = ?, bio = ? WHERE id = ?");
    $stmt->execute([$hashed_password, $nom, $prenom, $date_naissance, $adresse, $bio, $userId]);

    // 处理头像更新
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
        // 先获取当前用户的旧头像路径
        $stmt = $dbConn->db->prepare("SELECT url_avatar FROM user WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $oldAvatar = $user['url_avatar'];
        
        if ($oldAvatar) {
            // 如果存在旧头像，则从服务器上删除
            $oldAvatarPath = __DIR__ . '/path/to/avatars/' . $oldAvatar;
            if (file_exists($oldAvatarPath)) {
                unlink($oldAvatarPath);
            }
        }

        // 保存新头像
        $newAvatarName = $userId . '_' . time() . '.jpg'; // 基本的命名方式
        move_uploaded_file($_FILES['avatar']['tmp_name'], __DIR__ . '/path/to/avatars/' . $newAvatarName);

        // 更新数据库中的头像URL
        $stmt = $dbConn->db->prepare("UPDATE user SET url_avatar = ? WHERE id = ?");
        $stmt->execute([$newAvatarName, $userId]);
    }

    // 更新成功后重定向回主页
    header("Location: index.php");
} else {
    if ($dbConn->loginStatus->loginAttempted){
        echo '<br><br><h3 class="errorMessage">'.$dbConn->loginStatus->errorText.'</h3><br><br><br>';
    }
    include(__ROOT__."/codePart/loginForm.php");
}

?>

<p><a href="./newUser.php" class="endlink">Créer un nouveau compte </a><br><br></p>

<?php 
include(__ROOT__ ."/codePart/footer.php");
?>
