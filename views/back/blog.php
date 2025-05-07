<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Blog Management</title>
</head>
<style>
        .posts-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .post-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: relative;
        }
        
        .post-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: #4CAF50;
            color: white;
        }
        
        .btn-danger {
            background: #f44336;
            color: white;
        }
        
        .btn-edit {
            background: #2196F3;
            color: white;
        }
        
        .create-post-btn {
            margin-bottom: 20px;
        }
        
        .comments-section {
            margin-top: 15px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        
        .comment-item {
            padding: 10px;
            background: #f9f9f9;
            border-radius: 5px;
            margin-bottom: 10px;
            position: relative;
        }
        
        .comment-delete {
            position: absolute;
            right: 10px;
            top: 10px;
            color: #f44336;
            cursor: pointer;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }
        
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border-radius: 10px;
            width: 50%;
            max-width: 600px;
        }
        
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .form-group textarea {
            min-height: 100px;
        }
    </style>
<body>
    <div class="container">
        <!-- Sidebar Section -->
        <aside>
            <div class="toggle">
                <div class="logo">
                    <img src="images/">
                    <h2>WE<span class="danger">RENT</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">
                        close
                    </span>
                </div>
            </div>

            <div class="sidebar">
                <a href="index.php">
                    <span class="material-icons-sharp">
                        dashboard
                    </span>
                    <h3>Dashboard</h3>
                </a>
                <a href="#">

                    <span class="material-icons-sharp">
                        person_outline
                    </span>
                    <h3>Users</h3>
                </a>
                <a href="blog.php" class="active">
                    <span class="material-icons-sharp">
                        receipt_long
                    </span>
                    <h3>Blog</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">
                        insights
                    </span>
                    <h3>Analytics</h3>
                </a>
                <a href="complaint.php">
                    <span class="material-icons-sharp">
                        mail_outline
                    </span>
                    <h3>Complaint</h3>
                    <span class="message-count">27</span>
                </a>
                <a href="event.php">
                    <span class="material-icons-sharp">
                        inventory
                    </span>
                    <h3>Event</h3>
                </a>
                <a href="annoucement.php">
                    <span class="material-icons-sharp">
                        report_gmailerrorred
                    </span>
                    <h3>Announcement</h3>
                </a>
                <a href="#">

                    <span class="material-icons-sharp">
                        add
                    </span>
                    <h3>New Login</h3>
                </a>
                <a href="#" id="logout-btn">
                    <span class="material-icons-sharp">
                        logout
                    </span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <h1>Blog Management</h1>
            
            <!-- Create Post Button -->
            <button class="btn btn-primary create-post-btn" id="createPostBtn">
                <i class="fas fa-plus"></i> Create New Post
            </button>
            
            <div class="posts-container">
                <?php
                require_once '../../models/Blog.php';
                $blog = new Blog();
                $posts = $blog->getPosts();

                if (empty($posts)) {
                    echo '<p>No posts have been published yet.</p>';
                } else {
                    foreach ($posts as $post) {
                        $comments = $blog->getComments($post['id']);
                        echo '<div class="post-card" id="post-' . $post['id'] . '">';
                        echo '<h4>' . htmlspecialchars($post['title']) . '</h4>';
                        echo '<p>' . htmlspecialchars($post['message']) . '</p>';
                        
                        if (!empty($post['image'])) {
                            echo '<img src="../../uploads/' . htmlspecialchars($post['image']) . '" alt="Post Image" style="max-width:100%; margin-top:10px;">';
                        }
                        
                        // Post actions
                        echo '<div class="post-actions">';
                        echo '<button class="btn btn-edit edit-post" data-post-id="' . $post['id'] . '">';
                        echo '<i class="fas fa-edit"></i> Edit</button>';
                        echo '<button class="btn btn-danger delete-post" data-post-id="' . $post['id'] . '">';
                        echo '<i class="fas fa-trash"></i> Delete</button>';
                        echo '</div>';
                        
                        // Comments section
                        echo '<div class="comments-section">';
                        echo '<h5>Comments</h5>';
                        
                        if (!empty($comments)) {
                            foreach ($comments as $comment) {
                                echo '<div class="comment-item" data-comment-id="' . $comment['id'] . '">';
                                echo '<strong>User ' . htmlspecialchars($comment['user_id']) . '</strong>';
                                echo '<p>' . htmlspecialchars($comment['comment']) . '</p>';
                                echo '<small>' . htmlspecialchars($comment['created_at']) . '</small>';
                                echo '<div class="comment-actions">';
                                echo '<button class="btn btn-edit edit-comment" data-comment-id="' . $comment['id'] . '" data-post-id="' . $post['id'] . '">';
                                echo '<i class="fas fa-edit"></i> Edit</button>';
                                echo '<button class="btn btn-danger delete-comment" data-comment-id="' . $comment['id'] . '" data-post-id="' . $post['id'] . '">';
                                echo '<i class="fas fa-trash"></i> Delete</button>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p>No comments yet</p>';
                        }
                        echo '</div>';
                        
                        echo '</div>'; // Close post-card
                    }
                }
                ?>
            </div>
        </main>
        <!-- End of Main Content -->
    </div>

    <!-- Create/Edit Post Modal -->
    <div id="postModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Create New Post</h2>
            <form id="postForm" enctype="multipart/form-data">
                <input type="hidden" id="postId" name="postId">
                <div class="form-group">
                    <label for="postTitle">Title</label>
                    <input type="text" id="postTitle" name="postTitle" required>
                </div>
                <div class="form-group">
                    <label for="postMessage">Message</label>
                    <textarea id="postMessage" name="postMessage" required></textarea>
                </div>
                <div class="form-group">
                    <label for="postImage">Image (optional)</label>
                    <input type="file" id="postImage" name="postImage" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary">Save Post</button>
            </form>
        </div>
    </div>

    <script>
        // DOM Elements
        const createPostBtn = document.getElementById('createPostBtn');
        const postModal = document.getElementById('postModal');
        const modalTitle = document.getElementById('modalTitle');
        const closeBtn = document.querySelector('.close');
        const postForm = document.getElementById('postForm');
        
        // Open modal for creating new post
        createPostBtn.addEventListener('click', () => {
            document.getElementById('postId').value = '';
            document.getElementById('postTitle').value = '';
            document.getElementById('postMessage').value = '';
            document.getElementById('postImage').value = '';
            modalTitle.textContent = 'Create New Post';
            postModal.style.display = 'block';
        });
        
        // Close modal
        closeBtn.addEventListener('click', () => {
            postModal.style.display = 'none';
        });
        
        // Close modal when clicking outside
        window.addEventListener('click', (e) => {
            if (e.target === postModal) {
                postModal.style.display = 'none';
            }
        });
        
        // Add this to your JavaScript
function showFormFeedback(message, isError = false) {
    const feedbackEl = document.getElementById('formFeedback');
    feedbackEl.textContent = message;
    feedbackEl.style.color = isError ? 'red' : 'green';
    feedbackEl.style.display = 'block';
    
    setTimeout(() => {
        feedbackEl.style.display = 'none';
    }, 5000);
}

// Update your form submission handler to use this:
postForm.addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const postId = document.getElementById('postId').value;
    formData.append('action', postId ? 'edit_post' : 'create_post');

    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

    fetch('../../controllers/BlogController.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log('Response Status:', response.status); // Debugging log
        return response.json();
    })
    .then(data => {
        console.log('Response Data:', data); // Debugging log
        if (data.status === 'success') {
            alert(data.message);
            postModal.style.display = 'none';
            location.reload();
        } else {
            alert(data.message || 'Failed to save post');
        }
    })
    .catch(error => {
        console.error('Fetch Error:', error); // Debugging log
        alert('An error occurred while saving the post.');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Save Post';
    });
});

// Handle "Edit" button click
document.querySelectorAll('.edit-post').forEach(button => {
    button.addEventListener('click', function () {
        const postId = this.getAttribute('data-post-id');

        // Fetch post data from the backend
        fetch(`../../controllers/BlogController.php?action=get_post&postId=${postId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response Data:', data); // Log response data for debugging
                if (data.status === 'success') {
                    // Populate modal with post data
                    document.getElementById('postId').value = data.post.id;
                    document.getElementById('postTitle').value = data.post.title;
                    document.getElementById('postMessage').value = data.post.message;
                    modalTitle.textContent = 'Edit Post';
                    postModal.style.display = 'block';
                } else {
                    alert(data.message || 'Failed to fetch post data');
                }
            })
            .catch(error => {
                console.error('Error fetching post data:', error); // Log error details
                alert('An error occurred while fetching the post data.');
            });
    });
});

// Delete post functionality
document.querySelectorAll('.delete-post').forEach(button => {
    button.addEventListener('click', function() {
        const postId = this.getAttribute('data-post-id');
        if (confirm('Are you sure you want to delete this post?')) {
            fetch('../../controllers/BlogController.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=delete_post&postId=${postId}`
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === 'success') {
                    document.getElementById('post-' + postId).remove();
                    alert('Post deleted successfully.');
                } else {
                    alert('Failed to delete post. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the post.');
            });
        }
    });
});

// Handle "Edit Comment" button click
document.querySelectorAll('.edit-comment').forEach(button => {
    button.addEventListener('click', function () {
        const commentId = this.getAttribute('data-comment-id');
        const postId = this.getAttribute('data-post-id');
        const commentText = this.closest('.comment-item').querySelector('p').textContent.trim();

        // Populate modal with comment data
        document.getElementById('commentId').value = commentId;
        document.getElementById('postId').value = postId;
        document.getElementById('commentText').value = commentText;
        document.getElementById('commentModalTitle').textContent = 'Edit Comment';
        document.getElementById('commentModal').style.display = 'block';
    });
});

// Handle "Save Comment Changes" button click
document.getElementById('saveCommentChanges').addEventListener('click', function () {
    const commentId = document.getElementById('commentId').value;
    const commentText = document.getElementById('commentText').value;

    if (!commentText.trim()) {
        alert('Comment cannot be empty.');
        return;
    }

    fetch('../../controllers/BlogController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=edit_comment&commentId=${commentId}&comment=${encodeURIComponent(commentText)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Comment updated successfully.');
            location.reload(); // Reload the page to reflect changes
        } else {
            alert(data.message || 'Failed to update comment.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the comment.');
    });
});

// Handle "Delete Comment" button click
document.querySelectorAll('.delete-comment').forEach(button => {
    button.addEventListener('click', function () {
        const commentId = this.getAttribute('data-comment-id');
        const commentElement = this.closest('.comment-item');

        if (confirm('Are you sure you want to delete this comment?')) {
            const formData = new FormData();
            formData.append('action', 'delete_comment');
            formData.append('commentId', commentId);

            fetch('../../controllers/BlogController.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                if (data.trim() === 'success') {
                    commentElement.remove();
                    alert('Comment deleted successfully.');
                    
                    // If there are no more comments, show "No comments yet" message
                    const commentsSection = commentElement.closest('.comments-section');
                    const remainingComments = commentsSection.querySelectorAll('.comment-item');
                    if (remainingComments.length === 0) {
                        const noCommentsMsg = document.createElement('p');
                        noCommentsMsg.textContent = 'No comments yet';
                        commentsSection.appendChild(noCommentsMsg);
                    }
                } else {
                    alert('Failed to delete comment. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the comment.');
            });
        }
    });
});

// Logout functionality
document.getElementById('logout-btn').addEventListener('click', function(e) {
    e.preventDefault();
    alert('You have been logged out.');
    window.location.href = '../front/user-management.html';
});
    </script>

    <!-- Edit Comment Modal -->
<div id="commentModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('commentModal').style.display='none'">&times;</span>
        <h2 id="commentModalTitle">Edit Comment</h2>
        <form id="commentForm">
            <input type="hidden" id="commentId" name="commentId">
            <input type="hidden" id="postId" name="postId">
            <div class="form-group">
                <label for="commentText">Comment</label>
                <textarea id="commentText" name="commentText" required></textarea>
            </div>
            <button type="button" id="saveCommentChanges" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</div>

</body>
</html>