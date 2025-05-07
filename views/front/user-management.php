<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WeRent - Login</title>
    
    <!-- load stylesheets -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/user-management.css">
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
                <h2 class="text-center mb-4">Login</h2>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <form id="login-form">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" placeholder="Enter username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Enter password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
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
        $(function() {
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

            $('#login-form').on('submit', function(e) {
                e.preventDefault();
                const username = $('#username').val();
                const password = $('#password').val();

                // Validate credentials
                if (username === 'andolsi' && password === 'andolsi') {
                    alert('Login successful!');
                    window.location.href = '../back/index.php'; // Redirect to back index
                } else {
                    alert('Invalid username or password.');
                }
            });
        });
    </script>
</body>
</html>