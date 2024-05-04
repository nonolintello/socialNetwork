<?php
include("./ini.php");
include(__ROOT__. "/codePart/header.php");

if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    $password = $_POST['password']?? null;
    $confirm_password = $_POST['confirm_password']?? null;
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_naissance = $_POST['date_naissance'];
    $adresse = $_POST['adresse'];
    $bio = $_POST['bio']; // 接收表单中的个人简介

    $updateFields = [
        'nom' => $nom,
        'prenom' => $prenom,
        'date_naissance' => $date_naissance,
        'adresse' => $adresse,
        'bio' => $bio
    ];
    if ($password && $confirm_password) {
        if ($password !== $confirm_password) {
            die("Passwords do not match.");
        }else {
                // 更新密码前先进行加密
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $updateFields['mdp'] = $hashed_password; // 只有在密码确认正确时才更新密码
        }
    }
    // 构建更新SQL语句
    $sqlParts = [];
    foreach ($updateFields as $field => $value) {
        $sqlParts[] = "$field = :$field";
    }
    $sqlStatement = "UPDATE user SET " . implode(', ', $sqlParts) . " WHERE id = :id";
    
    $stmt = $dbConn->db->prepare($sqlStatement);
    foreach ($updateFields as $field => $value) {
        $stmt->bindParam(":$field", $updateFields[$field]);
    }
    $stmt->bindParam(':id', $userId);
    $stmt->execute();

    // 处理头像更新
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
        $oldAvatar = $_FILES['avatar']['name']; // 假设有旧头像名
        $newAvatarName = $userId . '_' . time() . '.jpg'; // 基本的命名方式
        move_uploaded_file($_FILES['avatar']['tmp_name'], __DIR__ . '/path/to/avatars/' . $newAvatarName);

        // 更新数据库中的头像URL
        $stmt = $dbConn->db->prepare("UPDATE user SET url_avatar = ? WHERE id = ?");
        $stmt->execute([$newAvatarName, $userId]);
    }

    // 更新成功后重定向回主页
    header("Location: profile.php");
} else {
    if ($dbConn->loginStatus->loginAttempted) {
        echo '<br><br><h3 class="errorMessage">'.$dbConn->loginStatus->errorText.'</h3><br><br><br>';
    }
    include(__DIR__."/codePart/loginForm.php");
}

include(__ROOT__ ."/codePart/footer.php");
?>
