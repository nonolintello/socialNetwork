<?php
include("./ini.php");
include(__ROOT__ . "/codePart/header.php");

// 获取查看的用户ID，如果未指定，则默认为登录用户ID
$viewedUserId = isset($_GET['id']) ? $_GET['id'] : $_SESSION['id'];

if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];

    // 获取用户数据
    $stmt = $dbConn->db->prepare("SELECT * FROM user WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // 显示用户信息
    echo '<div class="user-profile">';
    echo '<img src="' . htmlspecialchars($user['url_avatar']) . '" alt="User avatar" class="avatar">';
    echo '<h1>' . htmlspecialchars($user['prenom']) . ' ' . htmlspecialchars($user['nom']) . '</h1>';
    echo '<p>' . htmlspecialchars($user['bio']) . '</p>';
    echo '<ul>';
    echo '<li>Email: ' . htmlspecialchars($user['email']) . '</li>';
    echo '<li>Birthday: ' . htmlspecialchars($user['date_naissance']) . '</li>';
    echo '<li>Address: ' . htmlspecialchars($user['adresse']) . ', ' . htmlspecialchars($user['cp']) . ', ' . htmlspecialchars($user['commune']) . '</li>';
    echo '</ul>';

    // 如果查看的不是登录用户本人的页面，则显示关注按钮
    if ($userId !== $viewedUserId) {
    // 检查是否已关注
    $stmt = $dbConn->db->prepare("SELECT * FROM follow WHERE id_follower = ? AND id_isfollow = ?");
    $stmt->execute([$userId, $userId]); // 假设要检查的用户是自己
    $isFollowing = $stmt->fetch() ? "Unfollow" : "Follow";
    // Follow/Unfollow Button
    echo "<button id='followButton' onclick='toggleFollow($userId)'>$isFollowing</button>";
    }
    echo '<script>
            function toggleFollow(followId) {
                fetch(`follow.php?follow_id=${followId}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById("followButton").innerText = data;
                }).catch(error => console.error("Error:", error));
            }
          </script>';
    echo '</div>';


    // JavaScript内联，用于加载统计数据
    echo '<h2>Your Personal Statistics</h2>';
    echo '<div id="statistics"></div>';
    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                fetch("fetchStatistics.php")
                .then(response => response.json())
                .then(data => {
                    document.getElementById("statistics").innerHTML =
                    "<ul>" +
                    "<li>Followers: " + data.followers + "</li>" +
                    "<li>Following: " + data.following + "</li>" +
                    "<li>Total Posts: " + data.total_posts + "</li>" +
                    "<li>Likes Given: " + data.likes_given + "</li>" +
                    "<li>Likes Received: " + data.likes_received + "</li>" +
                    "</ul>";
                }).catch(error => console.error("Error loading the statistics:", error));
            });
          </script>';

    if ($userId == $viewedUserId) {
    // 表单用于更新用户信息
    echo '<h2>Update Your Profile</h2>';
    echo '<form id="updateProfileForm" action="updateProfile.php" method="post" enctype="multipart/form-data">
            Email: <input type="email" name="email" value="' . htmlspecialchars($user['email']) . '" readonly><br>
            New Password: <input type="password" name="password"><br>
            Confirm New Password: <input type="password" name="confirm_password"><br>
            Name: <input type="text" name="nom" value="' . htmlspecialchars($user['nom']) . '"><br>
            First Name: <input type="text" name="prenom" value="' . htmlspecialchars($user['prenom']) . '"><br>
            Birthday: <input type="date" name="date_naissance" value="' . htmlspecialchars($user['date_naissance']) . '"><br>
            Address: <input type="text" name="adresse" value="' . htmlspecialchars($user['adresse']) . '"><br>
            Biography: <input type="text" name="bio" value="' . htmlspecialchars($user['bio']) . '"><br>
            Change Avatar: <input type="file" name="avatar"><br>
            <button type="submit">Update Profile</button>
          </form>';
    }
    
} else {
    // 用户未登录时的按钮行为
    echo "<button id='followButton' onclick='alert(\"You have to login if you want to follow.\")'>Follow</button>";
echo '<script>
        function toggleFollow(followId) {
            if (' . (isset($_SESSION['id']) ? 'true' : 'false') . ') {
                fetch(`follow.php?follow_id=${followId}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById("followButton").innerText = data;
                }).catch(error => console.error("Error:", error));
            } else {
                alert("您必须登录才能关注用户。");
            }
        }
      </script>';
    // 登录表单
    if ($dbConn->loginStatus->loginAttempted) {
        echo '<br><br><h3 class="errorMessage">' . $dbConn->loginStatus->errorText . '</h3><br><br><br>';
    }
    include(__ROOT__ . "/codePart/loginForm.php");
}

echo '<p><a href="./newUser.php" class="endlink">Créer un nouveau compte </a><br><br></p>';

include(__ROOT__ . "/codePart/footer.php");
?>
