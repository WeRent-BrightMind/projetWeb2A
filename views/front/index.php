<?php
require_once __DIR__ . '/../../config/database.php';

try {
    $database = new Database();
    $conn = $database->getConnection();
} catch (Exception $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>WeRent-Home</title>


    <!-- load stylesheets -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">  <!-- Google web font "Open Sans" -->
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">                <!-- Font Awesome -->
    <link rel="stylesheet" href="css/bootstrap.min.css">                                      <!-- Bootstrap style -->
    <link rel="stylesheet" type="text/css" href="css/datepicker.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
    <link rel="stylesheet" href="css/templatemo-style.css">                                   <!-- Templatemo style -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
              <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
          <![endif]-->
      </head>

      <body>
        <div class="tm-main-content" id="top">
            <div class="tm-top-bar-bg"></div>    
            <div class="tm-top-bar" id="tm-top-bar">
                <div class="container">
                    <div class="row">
                        <nav class="navbar navbar-expand-lg narbar-light">
                            <a class="navbar-brand mr-auto" href="#">
                                <img src="img/logo.png" alt="Site logo">
                                WeRent
                            </a>
                            <button type="button" id="nav-toggle" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#mainNav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div id="mainNav" class="collapse navbar-collapse tm-bg-white">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#top">Home <span class="sr-only">(current)</span></a>
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
                    </div> <!-- row -->
                </div> <!-- container -->
            </div> <!-- .tm-top-bar -->

            <div class="tm-page-wrap mx-auto">
                <section class="tm-banner">
                    <div class="tm-container-outer tm-banner-bg">
                        <div class="container">

                            <div class="row tm-banner-row tm-banner-row-header">
                                <div class="col-xs-12">
                                    <div class="tm-banner-header">
                                        <h1 class="text-uppercase tm-banner-title">Rent Everything</h1>
                                        <img src="img/dots-3.png" alt="Dots">
                                        <p class="tm-banner-subtitle">We assist you to pick rentable necessities.</p>
                                               
                                    </div>    
                                </div>  <!-- col-xs-12 -->                      
                            </div> <!-- row -->
                            <div class="row tm-banner-row" id="tm-section-search">
                                <div class="col-12">
                                    <div class="tm-banner-header">
                                        <h2 class="text-uppercase tm-banner-title" align="center">Our Services</h2>
                                       <div align="center">
                                        <img src="img/dots-3.png" alt="Dots">
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row tm-banner-row">
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <i class="fa fa-users fa-3x mb-3 text-primary"></i>
                                            <h4 class="card-title">User Management</h4>
                                            <p class="card-text">Manage user accounts and profiles</p>
                                            <a href="user-management.html" class="btn btn-primary">Access</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <i class="fa fa-exclamation-triangle fa-3x mb-3 text-success"></i>
                                            <h4 class="card-title">Complaint Management</h4>
                                            <p class="card-text">Handle user complaints and feedback</p>
                                            <a href="complaint-management.html" class="btn btn-success">Access</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <i class="fa fa-blog fa-3x mb-3 text-info"></i>
                                            <h4 class="card-title">Blog Management</h4>
                                            <p class="card-text">Manage blog posts and content</p>
                                            <a href="blog-management.html" class="btn btn-info">Access</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <i class="fa fa-bullhorn fa-3x mb-3 text-warning"></i>
                                            <h4 class="card-title">Announcement Management</h4>
                                            <p class="card-text">Post and manage announcements</p>
                                            <a href="announcement-management.html" class="btn btn-warning">Access</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <i class="fa fa-calendar-alt fa-3x mb-3 text-danger"></i>
                                            <h4 class="card-title">Event Management</h4>
                                            <p class="card-text">Manage events and schedules</p>
                                            <a href="event-management.html" class="btn btn-danger">Access</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tm-banner-overlay"></div>
                        </div>  <!-- .container -->                   
                    </div>     <!-- .tm-container-outer -->                 
                </section>

                <div class="tm-container-outer" id="tm-section-2">
                    <section class="tm-slideshow-section">
                        <div class="tm-slideshow">
                            <img src="img/tm-img-01.jpg" alt="Image" height="500" width="700">
  
                        </div>
                        <div class="tm-slideshow-description tm-bg-primary">
                            <h2 class="">Europe's most visited places</h2>
                            <p>Aenean in lacus nec dolor fermentum congue. Maecenas ut velit pharetra, pharetra tortor sit amet, vulputate sem. Vestibulum mi nibh, faucibus ac eros id, sagittis tincidunt velit. Proin interdum ullamcorper faucibus. Ut mi nunc, sollicitudin non pulvinar id, sagittis eget diam.</p>
                            <a href="#" class="text-uppercase tm-btn tm-btn-white tm-btn-white-primary">Continue Reading</a>
                        </div>
                    </section>
                    <section class="clearfix tm-slideshow-section tm-slideshow-section-reverse">
    
                        <div class="tm-right tm-slideshow tm-slideshow-highlight">
                            <img src="img/tm-img-02.jpg" alt="Image" height="500" width="700">

                        </div> 
    
                        <div class="tm-slideshow-description tm-slideshow-description-left tm-bg-highlight">
                            <h2 class="">Asia's most popular places</h2>
                            <p>Vivamus in massa ullamcorper nunc auctor accumsan ac at arcu. Donec sagittis mattis pharetra. Proin commodo, ante et volutpat pulvinar, arcu arcu ullamcorper diam, id maximus sem tellus id sem. Suspendisse eget rhoncus diam. Fusce urna elit, porta nec ullamcorper id.</p>
                            <a href="#" class="text-uppercase tm-btn tm-btn-white tm-btn-white-highlight">Continue Reading</a>
                        </div>                         
    
                    </section>
                    <section class="tm-slideshow-section">
                        <div class="tm-slideshow">
                            <img src="img/tm-img-03.jpg" alt="Image" >
                        </div>
                        <div class="tm-slideshow-description tm-bg-primary">
                            <h2 class="">America's most famous places</h2>
                            <p>Donec nec laoreet diam, at vehicula ante. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse nec dapibus nunc, quis viverra metus. Morbi eget diam gravida, euismod magna vel, tempor urna.</p>
                            <a href="#" class="text-uppercase tm-btn tm-btn-white tm-btn-white-primary">Continue Reading</a>
                        </div>
                    </section>
                
                </div>        
                <div class="tm-container-outer" id="tm-section-3">
                    
                    <div class="tab-content clearfix">
                    	
                        <!-- Tab 1 -->
                        <div class="tab-pane fade" id="1a">
                            <div class="tm-recommended-place-wrap">
                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-06.jpg" alt="Image" class="img-fluid tm-recommended-img" style="max-width: 200px; height: auto;">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">North Garden Resort</h3>
                                        <p class="tm-text-highlight">One North</p>
                                        <p class="tm-text-gray">Sed egestas, odio nec bibendum mattis, quam odio hendrerit risus, eu varius eros lacus sit amet lectus. Donec blandit luctus dictum...</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">$110</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>                        
                                </div>

                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-07.jpg" alt="Image" class="img-fluid tm-recommended-img" style="max-width: 200px; height: auto;">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Felis nec dignissim</h3>
                                        <p class="tm-text-highlight">Two North</p>
                                        <p class="tm-text-gray">Sed egestas, odio nec bibendum mattis, quam odio hendrerit risus, eu varius eros lacus sit amet lectus. Donec blandit luctus dictum...</p>   
                                    </div>
                                    <div id="preload-hover-img"></div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">$120</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>
                                </div>

                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-05.jpg" alt="Image" class="img-fluid tm-recommended-img" style="max-width: 200px; height: auto;">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Sed fermentum justo</h3>
                                        <p class="tm-text-highlight">Three North</p>
                                        <p class="tm-text-gray">Sed egestas, odio nec bibendum mattis, quam odio hendrerit risus, eu varius eros lacus sit amet lectus. Donec blandit luctus dictum...</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">$130</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>
                                </div>

                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-04.jpg" alt="Image" class="img-fluid tm-recommended-img" style="max-width: 200px; height: auto;">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Maecenas ultricies neque</h3>
                                        <p class="tm-text-highlight">Four North</p>
                                        <p class="tm-text-gray">Sed egestas, odio nec bibendum mattis, quam odio hendrerit risus, eu varius eros lacus sit amet lectus. Donec blandit luctus dictum...</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">$140</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>
                                </div>    
                            </div>                        

                            <a href="#" class="text-uppercase btn-primary tm-btn mx-auto tm-d-table">Show More Places</a>
                        </div> <!-- tab-pane -->
                        
                        <!-- Tab 2 -->
                        <div class="tab-pane fade" id="2a">

                            <div class="tm-recommended-place-wrap">
                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-05.jpg" alt="Image" class="img-fluid tm-recommended-img" style="max-width: 200px; height: auto;">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">South Resort Hotel</h3>
                                        <p class="tm-text-highlight">South One</p>
                                        <p class="tm-text-gray">Sed egestas, odio nec bibendum mattis, quam odio hendrerit risus, eu varius eros lacus sit amet lectus. Donec blandit luctus dictum...</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">$220</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>                        
                                </div>

                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-04.jpg" alt="Image" class="img-fluid tm-recommended-img" style="max-width: 200px; height: auto;">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Aenean ac ante nec diam</h3>
                                        <p class="tm-text-highlight">South Second</p>
                                        <p class="tm-text-gray">Sed egestas, odio nec bibendum mattis, quam odio hendrerit risus, eu varius eros lacus sit amet lectus. Donec blandit luctus dictum...</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">$230</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>
                                </div>

                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-07.jpg" alt="Image" class="img-fluid tm-recommended-img" style="max-width: 200px; height: auto;">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Suspendisse nec dapibus</h3>
                                        <p class="tm-text-highlight">South Third</p>
                                        <p class="tm-text-gray">Sed egestas, odio nec bibendum mattis, quam odio hendrerit risus, eu varius eros lacus sit amet lectus. Donec blandit luctus dictum...</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">$240</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>
                                </div>

                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-06.jpg" alt="Image" class="img-fluid tm-recommended-img" style="max-width: 200px; height: auto;">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Aliquam viverra mi at nisl</h3>
                                        <p class="tm-text-highlight">South Fourth</p>
                                        <p class="tm-text-gray">Sed egestas, odio nec bibendum mattis, quam odio hendrerit risus, eu varius eros lacus sit amet lectus. Donec blandit luctus dictum...</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">$250</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>
                                </div>    
                            </div>                        

                            <a href="#" class="text-uppercase btn-primary tm-btn mx-auto tm-d-table">Show More Places</a>
                        </div> <!-- tab-pane -->          
                        
                        <!-- Tab 3 -->     
                        <div class="tab-pane fade" id="3a">

                            <div class="tm-recommended-place-wrap">
                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-04.jpg" alt="Image" class="img-fluid tm-recommended-img" style="max-width: 200px; height: auto;">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Europe Hotel</h3>
                                        <p class="tm-text-highlight">Venecia, Italy</p>
                                        <p class="tm-text-gray">Sed egestas, odio nec bibendum mattis, quam odio hendrerit risus, eu varius eros lacus sit amet lectus. Donec blandit luctus dictum...</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">$330</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>                        
                                </div>

                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-05.jpg" alt="Image" class="img-fluid tm-recommended-img" style="max-width: 200px; height: auto;">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">In viverra enim turpis</h3>
                                        <p class="tm-text-highlight">Paris, France</p>
                                        <p class="tm-text-gray">Sed egestas, odio nec bibendum mattis, quam odio hendrerit risus, eu varius eros lacus sit amet lectus. Donec blandit luctus dictum...</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">$340</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>
                                </div>

                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-06.jpg" alt="Image" class="img-fluid tm-recommended-img" style="max-width: 200px; height: auto;">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Volutpat pellentesque</h3>
                                        <p class="tm-text-highlight">Barcelona, Spain</p>
                                        <p class="tm-text-gray">Sed egestas, odio nec bibendum mattis, quam odio hendrerit risus, eu varius eros lacus sit amet lectus. Donec blandit luctus dictum...</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">$350</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>
                                </div>

                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-07.jpg" alt="Image" class="img-fluid tm-recommended-img" style="max-width: 200px; height: auto;">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Grand Resort Pasha</h3>
                                        <p class="tm-text-highlight">Istanbul, Turkey</p>
                                        <p class="tm-text-gray">Sed egestas, odio nec bibendum mattis, quam odio hendrerit risus, eu varius eros lacus sit amet lectus. Donec blandit luctus dictum...</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">$360</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>
                                </div>    
                            </div>                        

                            <a href="#" class="text-uppercase btn-primary tm-btn mx-auto tm-d-table">Show More Places</a>
                        </div> <!-- tab-pane -->
                        
                        <!-- Tab 4 -->
                        <div class="tab-pane fade show active" id="4a">
                        <!-- Current Active Tab WITH "show active" classes in DIV tag -->
                            <div class="tm-recommended-place-wrap">
                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-06.jpg" alt="Image" class="img-fluid tm-recommended-img" height="280" width="170">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Vintage Costumes</h3>
                                        <p class="tm-text-highlight">Clothes</p>
                                        <p class="tm-text-gray">Switch up your style with trending outfits for every occasion—no commitment, no clutter. Stay chic sustainably, save money, and spark joy in every wear</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">129DT</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>                        
                                </div>

                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-07.jpg" alt="Image" class="img-fluid tm-recommended-img" hight="170" width="280">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Car Getaway</h3>
                                        <p class="tm-text-highlight">Vehicule</p>
                                        <p class="tm-text-gray">Need wheels? Choose flexible hourly, daily, or weekly rentals—no long-term costs or maintenance. Drive newer models, enjoy 24/7 support, and hit the road stress-free. </p>   
                                    </div>
                                    <div id="preload-hover-img"></div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">250DT</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>
                                </div>

                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-05.jpg" alt="Image" class="img-fluid tm-recommended-img" hight="170" width="280">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Better than Airbnb</h3>
                                        <p class="tm-text-highlight">Houses</p>
                                        <p class="tm-text-gray">Find your perfect short-term stay—cozy cabins, city apartments, or beach villas. No strings attached, just comfort and freedom.</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">500DT</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>
                                </div>

                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-04.jpg" alt="Image" class="img-fluid tm-recommended-img" hight="170" width="280">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Mechanical Supplies</h3>
                                        <p class="tm-text-highlight">Work Supplies</p>
                                        <p class="tm-text-gray">Access heavy-duty tools and specialized equipment—no upfront costs or maintenance. Scale your projects as needed, stay efficient, and budget-smart.</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">75DT</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>
                                </div>    
                            </div>                        

                            <a href="#" class="text-uppercase btn-primary tm-btn mx-auto tm-d-table">Show More Products</a>
                        </div> <!-- tab-pane -->
                        
                        <!-- Tab 5 -->
                        <div class="tab-pane fade" id="5a">

                            <div class="tm-recommended-place-wrap">
                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-05.jpg" alt="Image" class="img-fluid tm-recommended-img" style="max-width: 200px; height: auto;">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Africa Resort Hotel</h3>
                                        <p class="tm-text-highlight">First City</p>
                                        <p class="tm-text-gray">Sed egestas, odio nec bibendum mattis, quam odio hendrerit risus, eu varius eros lacus sit amet lectus. Donec blandit luctus dictum...</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">$550</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>                        
                                </div>

                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-04.jpg" alt="Image" class="img-fluid tm-recommended-img" style="max-width: 200px; height: auto;">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Aenean ac magna diam</h3>
                                        <p class="tm-text-highlight">Second City</p>
                                        <p class="tm-text-gray">Sed egestas, odio nec bibendum mattis, quam odio hendrerit risus, eu varius eros lacus sit amet lectus. Donec blandit luctus dictum...</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">$560</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>
                                </div>

                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-07.jpg" alt="Image" class="img-fluid tm-recommended-img" style="max-width: 200px; height: auto;">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Beach Barbecue Sunset</h3>
                                        <p class="tm-text-highlight">Third City</p>
                                        <p class="tm-text-gray">Sed egestas, odio nec bibendum mattis, quam odio hendrerit risus, eu varius eros lacus sit amet lectus. Donec blandit luctus dictum...</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">$570</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>
                                </div>

                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-06.jpg" alt="Image" class="img-fluid tm-recommended-img" style="max-width: 200px; height: auto;">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Grand Resort Pasha</h3>
                                        <p class="tm-text-highlight">Fourth City</p>
                                        <p class="tm-text-gray">Sed egestas, odio nec bibendum mattis, quam odio hendrerit risus, eu varius eros lacus sit amet lectus. Donec blandit luctus dictum...</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">$580</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>
                                </div>    
                            </div>                        

                            <a href="#" class="text-uppercase btn-primary tm-btn mx-auto tm-d-table">Show More Places</a>
                        </div> <!-- tab-pane -->   
                        
                        <!-- Tab 6 -->            
                        <div class="tab-pane fade" id="6a">

                            <div class="tm-recommended-place-wrap">
                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-04.jpg" alt="Image" class="img-fluid tm-recommended-img" style="max-width: 200px; height: auto;">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Hotel Australia</h3>
                                        <p class="tm-text-highlight">City One</p>
                                        <p class="tm-text-gray">Sed egestas, odio nec bibendum mattis, quam odio hendrerit risus, eu varius eros lacus sit amet lectus. Donec blandit luctus dictum...</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">$660</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>                        
                                </div>

                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-05.jpg" alt="Image" class="img-fluid tm-recommended-img" style="max-width: 200px; height: auto;">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Proin interdum ullamcorper</h3>
                                        <p class="tm-text-highlight">City Two</p>
                                        <p class="tm-text-gray">Sed egestas, odio nec bibendum mattis, quam odio hendrerit risus, eu varius eros lacus sit amet lectus. Donec blandit luctus dictum...</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">$650</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>
                                </div>

                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-06.jpg" alt="Image" class="img-fluid tm-recommended-img" style="max-width: 200px; height: auto;">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Beach Barbecue Sunset</h3>
                                        <p class="tm-text-highlight">City Three</p>
                                        <p class="tm-text-gray">Sed egestas, odio nec bibendum mattis, quam odio hendrerit risus, eu varius eros lacus sit amet lectus. Donec blandit luctus dictum...</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">$640</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>
                                </div>

                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-07.jpg" alt="Image" class="img-fluid tm-recommended-img" style="max-width: 200px; height: auto;">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Grand Resort Pasha</h3>
                                        <p class="tm-text-highlight">City Four</p>
                                        <p class="tm-text-gray">Sed egestas, odio nec bibendum mattis, quam odio hendrerit risus, eu varius eros lacus sit amet lectus. Donec blandit luctus dictum...</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">$630</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>
                                </div>    
                            </div>                        

                            <a href="#" class="text-uppercase btn-primary tm-btn mx-auto tm-d-table">Show More Places</a>
                        </div> <!-- tab-pane -->
                        
                        <!-- Tab 7 -->
                        <div class="tab-pane fade" id="7a">

                            <div class="tm-recommended-place-wrap">
                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-04.jpg" alt="Image" class="img-fluid tm-recommended-img" style="max-width: 200px; height: auto;">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Antartica Resort</h3>
                                        <p class="tm-text-highlight">Ant City One</p>
                                        <p class="tm-text-gray">Sed egestas, odio nec bibendum mattis, quam odio hendrerit risus, eu varius eros lacus sit amet lectus. Donec blandit luctus dictum...</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">$770</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>                        
                                </div>

                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-05.jpg" alt="Image" class="img-fluid tm-recommended-img" style="max-width: 200px; height: auto;">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Pulvinar Semper</h3>
                                        <p class="tm-text-highlight">Ant City Two</p>
                                        <p class="tm-text-gray">Sed egestas, odio nec bibendum mattis, quam odio hendrerit risus, eu varius eros lacus sit amet lectus. Donec blandit luctus dictum...</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">$230</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>
                                </div>

                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-06.jpg" alt="Image" class="img-fluid tm-recommended-img" style="max-width: 200px; height: auto;">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Cras vel sapien</h3>
                                        <p class="tm-text-highlight">Ant City Three</p>
                                        <p class="tm-text-gray">Sed egestas, odio nec bibendum mattis, quam odio hendrerit risus, eu varius eros lacus sit amet lectus. Donec blandit luctus dictum...</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">$140</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>
                                </div>

                                <div class="tm-recommended-place">
                                    <img src="img/tm-img-07.jpg" alt="Image" class="img-fluid tm-recommended-img" style="max-width: 200px; height: auto;">
                                    <div class="tm-recommended-description-box">
                                        <h3 class="tm-recommended-title">Nullam eget est</h3>
                                        <p class="tm-text-highlight">Ant City Four</p>
                                        <p class="tm-text-gray">Sed egestas, odio nec bibendum mattis, quam odio hendrerit risus, eu varius eros lacus sit amet lectus. Donec blandit luctus dictum...</p>   
                                    </div>
                                    <a href="#" class="tm-recommended-price-box">
                                        <p class="tm-recommended-price">$190</p>
                                        <p class="tm-recommended-price-link">Continue Reading</p>
                                    </a>
                                </div>    
                            </div>                        

                            <a href="#" class="text-uppercase btn-primary tm-btn mx-auto tm-d-table">Show More Places</a>
                        </div> <!-- tab-pane -->
                    </div>
                </div>
            </div>

            <div class="tm-container-outer tm-position-relative" id="tm-section-4">
                <footer class="tm-container-outer">
                    <p class="mb-0">Copyright © <span class="tm-current-year">2025</span> WeRent</p>
                </footer>
            </div> <!-- .tm-container-outer -->

        </div>
    </div> <!-- .main-content -->

    <!-- load JS files -->
    <script src="js/jquery-1.11.3.min.js"></script>             <!-- jQuery (https://jquery.com/download/) -->
    <script src="js/popper.min.js"></script>                    <!-- https://popper.js.org/ -->       
    <script src="js/bootstrap.min.js"></script>                 <!-- https://getbootstrap.com/ -->
    <script src="js/datepicker.min.js"></script>                <!-- https://github.com/qodesmith/datepicker -->
    <script src="js/jquery.singlePageNav.min.js"></script>      <!-- Single Page Nav (https://github.com/ChrisWojcik/single-page-nav) -->
    <script src="slick/slick.min.js"></script>                  <!-- http://kenwheeler.github.io/slick/ -->
    <script src="js/jquery.scrollTo.min.js"></script>           <!-- https://github.com/flesler/jquery.scrollTo -->
    <script> 
        /* Google Maps
        ------------------------------------------------*/
        var map = '';
        var center;

        function initialize() {
            var mapOptions = {
                zoom: 16,
                center: new google.maps.LatLng(37.769725, -122.462154),
                scrollwheel: false
            };

            map = new google.maps.Map(document.getElementById('google-map'),  mapOptions);

            google.maps.event.addDomListener(map, 'idle', function() {
              calculateCenter();
          });

            google.maps.event.addDomListener(window, 'resize', function() {
              map.setCenter(center);
          });
        }

        function calculateCenter() {
            center = map.getCenter();
        }

        function loadGoogleMap(){
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDVWt4rJfibfsEDvcuaChUaZRS5NXey1Cs&v=3.exp&sensor=false&' + 'callback=initialize';
            document.body.appendChild(script);
        } 

        /* DOM is ready
        ------------------------------------------------*/
        $(function(){

            // Change top navbar on scroll
            $(window).on("scroll", function() {
                if($(window).scrollTop() > 100) {
                    $(".tm-top-bar").addClass("active");
                } else {                    
                 $(".tm-top-bar").removeClass("active");
                }
            });

            // Smooth scroll to search form
            $('.tm-down-arrow-link').click(function(){
                $.scrollTo('#tm-section-search', 300, {easing:'linear'});
            });

            // Date Picker in Search form
            var pickerCheckIn = datepicker('#inputCheckIn');
            var pickerCheckOut = datepicker('#inputCheckOut');

            // Update nav links on scroll
            $('#tm-top-bar').singlePageNav({
                currentClass:'active',
                offset: 60
            });

            // Close navbar after clicked
            $('.nav-link').click(function(){
                $('#mainNav').removeClass('show');
            });

            // Slick Carousel
            $('.tm-slideshow').slick({
                infinite: true,
                arrows: true,
                slidesToShow: 1,
                slidesToScroll: 1
            });

            loadGoogleMap();                                       // Google Map                
            $('.tm-current-year').text(new Date().getFullYear());  // Update year in copyright           
        });

    </script>             

</body>
</html>