// login function
function login() {
    // name "admin"，password "admin"
    var username = document.getElementsByName('username')[0].value;
    var password = document.getElementsByName('password')[0].value;
    
    if (username === "admin" && password === "admin") {
        window.location.href = 'mainpage.php'; // skip to mainpage
    } else {
        alert("Invalid username or password. Please try again.");
    }
}


// JavaScript for mainpage.php (Main Page Function)

// Function to create a new post
function createPost() {
    var postText = document.getElementById('post-text').value;
    
    // Assuming AJAX request to submit the new post
    // Replace this with your actual code to submit the post to the server
    // Chatgpt did
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'submit_post.php');
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Assuming the server responds with JSON data containing the new post details
            var response = JSON.parse(xhr.responseText);
            // Call a function to display the new post on the page
            displayNewPost(response);
        } else {
            alert('Error: ' + xhr.statusText); // Handle server errors
        }
    };
    var data = JSON.stringify({ text: postText });
    xhr.send(data);
}

// display new posts on the page
function displayNewPost(postData) {
    var postsContainer = document.getElementById('posts-container');
    
    // Create a new post element
    var postElement = document.createElement('div');
    postElement.className = 'post';
    postElement.innerHTML = '<p>' + postData.text + '</p>' +
                             '<button class="like-button" onclick="likePost(this)">Like</button>' +
                             '<span class="like-count">0</span>' +
                             '<button class="dislike-button" onclick="dislikePost(this)">Dislike</button>' +
                             '<span class="dislike-count">0</span>' +
                             '<button class="comment-button" onclick="showCommentBox(this)">Comment</button>' +
                             '<div class="comment-box" style="display:none;">' +
                             '<textarea class="comment-textarea"></textarea>' +
                             '<button class="comment-send-button" onclick="sendComment(this)">Send</button>' +
                             '</div>' +
                             '<div class="comments"></div>';
    
    // Append the new post element to the posts container
    postsContainer.appendChild(postElement);
}


// insert image
function insertImage() {
    var input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    input.addEventListener('change', function() {
        var file = input.files[0]; 
        var reader = new FileReader(); 

        // read filefolder
        reader.onload = function(e) {
            var imageData = e.target.result;

            // insert image label
            var postText = document.getElementById('post-text');
            postText.value += '<img src="' + imageData + '" alt="Uploaded Image">';
        };
        reader.readAsDataURL(file);
    });
    
    // choisir
    input.click();
}

// like function
function likePost(button) {
    var likeCount = button.nextElementSibling;
    likeCount.textContent = parseInt(likeCount.textContent) + 1;
}

// dislike function
function dislikePost(button) {
    var dislikeCount = button.previousElementSibling;
    dislikeCount.textContent = parseInt(dislikeCount.textContent) + 1;
}

// show commit function
function showCommentBox(button) {
    var commentBox = button.nextElementSibling;
    commentBox.style.display = 'block';
}

// send commit function
function sendComment(button) {
    var commentTextarea = button.previousElementSibling;
    var commentText = commentTextarea.value;
    var commentsContainer = button.parentElement.nextElementSibling;
    commentsContainer.innerHTML += '<p>' + commentText + '</p>';
    commentTextarea.value = '';
}


// explore。php
// load and display posts from other users
function loadExplorePosts() {
    var postsContainer = document.getElementById('posts-container');
    
    // Assuming AJAX request to fetch posts from server
    // Replace this with your actual code to fetch posts from the server
    //Chatgpt did
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetch_explore_posts.php');
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Assuming the server responds with JSON data containing explore posts
            var explorePosts = JSON.parse(xhr.responseText);
            // Call a function to display the explore posts on the page
            displayExplorePosts(explorePosts);
        } else {
            console.error('Error fetching explore posts: ' + xhr.statusText); // Handle server errors
        }
    };
    xhr.send();
}

// display explore posts on the page
function displayExplorePosts(explorePosts) {
    var postsContainer = document.getElementById('posts-container');
    
    // clear the posts container before adding new posts
    postsContainer.innerHTML = '';

    // loop through the explore posts and display them on the page
    explorePosts.forEach(function(post) {
        var postElement = document.createElement('div');
        postElement.className = 'post';
        postElement.innerHTML = '<p>' + post.text + '</p>' +
                                '<img src="' + post.image + '" alt="Post Image">' +
                                '<button onclick="likePost(' + post.id + ')">Like</button>' +
                                '<span id="likes-count-' + post.id + '">Likes: ' + post.likes + '</span>' +
                                '<button onclick="dislikePost(' + post.id + ')">Dislike</button>' +
                                '<span id="dislikes-count-' + post.id + '">Dislikes: ' + post.dislikes + '</span>' +
                                '<button onclick="showComments(' + post.id + ')">Show Comments</button>' +
                                '<div id="comments-container-' + post.id + '"></div>' +
                                '<textarea id="comment-text-' + post.id + '" placeholder="Enter your comment"></textarea>' +
                                '<button onclick="submitComment(' + post.id + ')">Submit Comment</button>';
        postsContainer.appendChild(postElement);
    });
}