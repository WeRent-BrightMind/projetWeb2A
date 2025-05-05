<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WeRent - Blog Management</title>
    
    <!-- load stylesheets -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/blog-management.css">
    <link rel="stylesheet" href="css/templatemo-style.css">
</head>

<body>
    <div class="tm-main-content" id="top">
        <div class="tm-top-bar-bg"></div>    
        <div class="tm-top-bar" id="tm-top-bar">
            <div class="container">
                <div class="row">
                    <nav class="navbar navbar-expand-lg narbar-light">
                        <a class="navbar-brand mr-auto" href="index.html">
                            <img src="img/logo.png" alt="Site logo">
                            WeRent
                        </a>
                        <button type="button" id="nav-toggle" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#mainNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div id="mainNav" class="collapse navbar-collapse tm-bg-white">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="index.php">Home</a>
                                </li>
                                <li class="nav-item">
                                        <a class="nav-link" href="user-management.php">User Management</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="complaint-management.php">Complaint Management</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="blog-management.php">Blog Management</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="announcement-management.php">Announcement Management</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="event-management.php">Event Management</a>
                                    </li>
                            </ul>
                        </div>                            
                    </nav>
                </div>
            </div>
        </div>

        <div class="tm-page-wrap mx-auto">
            <div class="container mt-5">
                <h2 class="text-center mb-4">Blog Management</h2>
                
                <!-- Post Creation Form -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Create a New Post</h4>
                    </div>
                    <div class="card-body">
                        <form id="createPostForm" method="POST" action="../../controllers/BlogController.php" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="postTitle">Post Title</label>
                                <input type="text" class="form-control" name="postTitle" id="postTitle" placeholder="Enter post title" required>
                            </div>
                            <div class="form-group">
                                <label for="postMessage">Message</label>
                                <textarea class="form-control" name="postMessage" id="postMessage" rows="4" placeholder="Write your message here..." required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="postImage">Upload Image (Optional)</label>
                                <input type="file" class="form-control-file" name="postImage" id="postImage" accept="image/*">
                            </div>
                            <button type="submit" name="publishPost" class="btn btn-primary">Publish Post</button>
                        </form>
                    </div>
                </div>

                <!-- Posts Section -->
                <div id="postsSection">
                    <h3 class="mb-4">Published Posts</h3>
                    <?php
                    require_once '../../models/Blog.php';
                    $blog = new Blog();
                    $posts = $blog->getPosts();

                    if (empty($posts)) {
                        echo '<p>No posts have been published yet.</p>';
                    } else {
                        foreach ($posts as $post) {
                            $likeCount = $blog->getLikes($post['id']);
                            $comments = $blog->getComments($post['id']);
                            echo '<div class="card mb-4">';
                            echo '<div class="card-header">';
                            echo '<h5>' . htmlspecialchars($post['title']) . '</h5>';
                            echo '<small>Posted by Admin on ' . htmlspecialchars($post['created_at']) . '</small>';
                            echo '</div>';
                            echo '<div class="card-body">';
                            echo '<p>' . htmlspecialchars($post['message']) . '</p>';
                            if (!empty($post['image'])) {
                                echo '<img src="../../uploads/' . htmlspecialchars($post['image']) . '" alt="Post Image" class="img-fluid mb-3">';
                            }
                            echo '<button class="btn btn-sm btn-outline-primary like-btn" data-post-id="' . $post['id'] . '">';
                            echo '<i class="fa fa-thumbs-up"></i> Like (<span class="like-count">' . $likeCount . '</span>)';
                            echo '</button>';
                            echo '<div class="comments-section mt-3">';
                            echo '<h6>Comments</h6>';
                            echo '<ul class="list-unstyled">';
                            foreach ($comments as $comment) {
                                echo '<li><strong>User ' . $comment['user_id'] . ':</strong> ' . htmlspecialchars($comment['comment']) . '</li>';
                            }
                            echo '</ul>';
                            echo '<div class="input-group mt-3">';
                            echo '<input type="text" class="form-control comment-input" placeholder="Write a comment..." data-post-id="' . $post['id'] . '">';
                            echo '<div class="input-group-append">';
                            echo '<button class="btn btn-primary comment-btn" data-post-id="' . $post['id'] . '">Post</button>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="tm-container-outer tm-position-relative" id="tm-section-4">
            <footer class="tm-container-outer">
                <p class="mb-0">Copyright © <span class="tm-current-year">2025</span> WeRent</p>
            </footer>
        </div>
    </div>

    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(function(){
            // Change top navbar on scroll
            $(window).on("scroll", function() {
                if($(window).scrollTop() > 100) {
                    $(".tm-top-bar").addClass("active");
                } else {                    
                    $(".tm-top-bar").removeClass("active");
                }
            });

            // Close navbar after clicked
            $('.nav-link').click(function(){
                $('#mainNav').removeClass('show');
            });

            $('.tm-current-year').text(new Date().getFullYear());

            // Like button functionality
            $(document).on('click', '.like-btn', function() {
                const postId = $(this).data('post-id');
                const likeCountElem = $(this).find('.like-count');
                $.post('../../controllers/BlogController.php', { action: 'like', postId: postId }, function(data) {
                    likeCountElem.text(data);
                });
            });

            // Comment button functionality
            $(document).on('click', '.comment-btn', function() {
                const postId = $(this).data('post-id');
                const commentInput = $(this).closest('.input-group').find('.comment-input');
                const commentText = commentInput.val();
                const commentsSection = $(this).closest('.comments-section').find('ul');

                if (commentText.trim() !== '') {
                    $.post('../../controllers/BlogController.php', { action: 'comment', postId: postId, comment: commentText }, function(data) {
                        try {
                            const comments = JSON.parse(data);
                            commentsSection.empty();
                            comments.forEach(comment => {
                                commentsSection.append('<li><strong>User ' + comment.user_id + ':</strong> ' + comment.comment + '</li>');
                            });
                            commentInput.val('');
                        } catch (e) {
                            console.error("Failed to parse comments response:", data);
                        }
                    }).fail(function(xhr, status, error) {
                        console.error("Failed to add comment:", error);
                    });
                }
            });
        });
    </script>
</body>
</html>