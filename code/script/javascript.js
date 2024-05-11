$(document).ready(function() {
    $(document).on('click', '.like-button', function() {
        var $likeButton = $(this);
        var postId = $likeButton.data('post-id');
        var isLiked = $likeButton.hasClass('liked'); 

        var action = isLiked ? 'unlike' : 'like';

        $.post('like.php', { post_id: postId, action: action }, function(data) {
            var jsonData = JSON.parse(data);

            if (jsonData.success) {
                $('#like-count-' + postId).text(jsonData.like_count);

                if (isLiked) {
                    $likeButton.removeClass('liked');
                } else {
                    $likeButton.addClass('liked'); 
                }
            } else {x
                console.error("Erreur: " + jsonData.message);
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Erreur AJAX:", textStatus, errorThrown);
        });
    });
});

function showLoginPrompt() {
    alert("Vous devez être connecté pour liker ce post.");
}

function unfollow(followId) {
    fetch(`unfollow.php?follow_id=${followId}`)
    .then(response => response.text())
    .then(data => {
        alert("Vous vous êtes désabonné avec succès");
        location.reload(); 
    })
    .catch(error => console.error('Error:', error));
}

function toggleFollow(followId) {
    const button = document.getElementById('followButton');
    const currentText = button.innerText;
    const actionUrl = (currentText === "Follow") ? 'follow.php' : 'unfollow.php';

    fetch(`${actionUrl}?follow_id=${followId}`)
    .then(response => response.text())
    .then(text => {
        button.innerText = text.trim();
    })
    .catch(error => console.error('Error toggling follow:', error));
}

document.addEventListener("DOMContentLoaded", function() {
    var loadMoreBtnDiscover = document.getElementById('loadMoreBtnDiscover');
    var postContainerDiscover = document.querySelector('.postContainer');
    var sortType = document.getElementById('sortType');
    var sort = sortType ? sortType.getAttribute('sort') : null;

    if (loadMoreBtnDiscover && postContainerDiscover) {
        loadMoreBtnDiscover.addEventListener('click', function() {
            var offset = postContainerDiscover.childElementCount;
            var limit = 10; 
            var fetchUrl = `loadMePosts.php?offset=${offset}&limit=${limit}&sort=${sort}`;
            fetch(fetchUrl)
                .then(response => response.text())
                .then(data => {
                    postContainerDiscover.innerHTML += data; 
                })
                .catch(error => console.error("Erreur lors du chargement des posts:", error));
        });
    }

    var loadMoreBtnBlog = document.getElementById("loadMoreBtnBlog");
    var postContainerBlog = document.getElementById("blogPostsContainer");
    var offsetBlog = 5;
    var limitBlog = 5;
    var idContainer = document.getElementById('dataId');
    var userId = idContainer ? idContainer.getAttribute('userId') : null;

    if (loadMoreBtnBlog && postContainerBlog && userId) {
        loadMoreBtnBlog.addEventListener("click", function() {
            var fetchUrl = `loadMeBlog.php?user_id=${userId}&offset=${offsetBlog}&limit=${limitBlog}`;
            fetch(fetchUrl)
                .then(response => response.text())
                .then(data => {
                    postContainerBlog.insertAdjacentHTML("beforeend", data);
                    offsetBlog += limitBlog; 
                })
                .catch(error => console.error("Erreur lors du chargement des messages:", error));
        });
    }

});


function showReplyForm(postID) {
    var replyName= "replyContainer" + postID;
    fetch(`reponse.php?postID=${postID}`)
        .then(response => response.text())
        .then(data => {
            const replyContainer = document.getElementById(replyName);
            if (replyContainer) {
                replyContainer.innerHTML = data;
            }
        })
        .catch(error => console.error("Erreur lors du chargement du formulaire de réponse:", error));
}

//warning
document.addEventListener('DOMContentLoaded', function () {
    // 现在所有DOM元素都已加载完毕，可以安全地绑定事件和操作DOM了
    window.openWarningForm = function(postID, ownerID) {
        currentPostId = postID;
        currentOwnerId = ownerID;
        document.getElementById('warningForm').style.display = 'block';  // 显示警告表单
    };

    window.sendWarning = function(postID, ownerID) {
        var warningText = document.getElementById('warningText').value;  // 获取编辑后的警告文本
        fetch('processPost.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=warn&postID=${postID}&ownerID=${ownerID}&content=${encodeURIComponent(warningText)}`
        })
        .then(response => response.text())
        .then(data => {
            alert('Avertissement envoyé avec succès.');
            document.getElementById('warningForm').style.display = 'none';  // 发送成功后隐藏表单
        })
        .catch(error => {
            console.error('Erreur lors de l’envoi de l’avertissement:', error);
            alert('Erreur lors de l’envoi de l’avertissement.');
        });
    };
});

//sensible
document.addEventListener('DOMContentLoaded', function () {
    // 现在所有DOM元素都已加载完毕，可以安全地绑定事件和操作DOM了
    window.openSensibleForm = function(postID, ownerID) {
        currentPostId = postID;
        currentOwnerId = ownerID;
        document.getElementById('sensibleForm').style.display = 'block';  // 显示警告表单
    };

    window.sendSensible = function(postID, ownerID) {
        var sensibleText = document.getElementById('sensibleText').value;  // 获取编辑后的敏感文本
        fetch('processPost.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=sensible&postID=${postID}&ownerID=${ownerID}&content=${encodeURIComponent(sensibleText)}`
        })
        .then(response => response.text())
        .then(data => {
            alert('AvertissementMarqué avec succès comme sensible.');
            document.getElementById('sensibleForm').style.display = 'none';  // 发送成功后隐藏表单
        })
        .catch(error => {
            console.error('Marquer comme échec sensible:', error);
            alert('Marquer comme échec sensible.');
        });
    };
});

//removed
document.addEventListener('DOMContentLoaded', function () {
    // 现在所有DOM元素都已加载完毕，可以安全地绑定事件和操作DOM了
    window.openRemovedForm = function(postID, ownerID) {
        currentPostId = postID;
        currentOwnerId = ownerID;
        document.getElementById('removedForm').style.display = 'block';  // 显示警告表单
    };

    window.sendRemoved = function(postID, ownerID) {
        var removedText = document.getElementById('removedText').value;  // 获取编辑后的敏感文本
        fetch('processPost.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=removed&postID=${postID}&ownerID=${ownerID}&content=${encodeURIComponent(removedText)}`
        })
        .then(response => response.text())
        .then(data => {
            alert('Le message a été supprimé avec succès.');
            document.getElementById('removedForm').style.display = 'none';  // 发送成功后隐藏表单
        })
        .catch(error => {
            console.error('La suppression de ce message a échoué:', error);
            alert('La suppression de ce message a échoué.');
        });
    };
});


function openBanForm(userId) {
    var today = new Date().toISOString().split('T')[0]; // 获取当前日期
    var banFormHtml = `
        <div id="banForm" class="modal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background-color: rgba(0, 0, 0, 0.5); z-index: 1050;">
            <div class="modal-content" style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 90%; max-width: 500px; position: relative;">
                <span class="close" onclick="document.getElementById('banForm').style.display='none';" style="position: absolute; top: 10px; right: 20px; font-size: 1.5rem; color: #666; cursor: pointer;">&times;</span>
                <form action="banUser.php" method="post">
                    <input type="hidden" name="userId" value="${userId}">
                    <label for="banDate" style="font-weight: bold;">Sélectionnez la date d'interdiction:</label>
                    <input type="date" id="banDate" name="banDate" min="${today}" required style="width: 100%; padding: 8px; margin-top: 5px; margin-bottom: 10px; box-sizing: border-box; border-radius: 4px; border: 1px solid #ccc;">
                    <textarea name="banReason" rows="4" required style="width: 100%; padding: 8px; margin-top: 5px; margin-bottom: 10px; box-sizing: border-box; border-radius: 4px; border: 1px solid #ccc;">Vous avez été banni par les modérateurs pour violation répétée des règles de la communauté. Date de début du bannissement:${today}</textarea>
                    <button type="submit" class="btn btn-danger" style="background-color: #dc3545; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Utilisateur banni</button>
                </form>
            </div>
        </div>
    `;
    document.body.innerHTML += banFormHtml;
    document.getElementById('banForm').style.display = 'block';
}
