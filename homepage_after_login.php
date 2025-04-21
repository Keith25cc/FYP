<?php
    session_start();

    if (isset($_SESSION["member_id"])) {
        include("member_header.php");
    } else {
        include("before_login_header.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="manifest" href="manifest.json" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MY Trade</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow-x: hidden;
        }

        .hero-section {
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        #bg-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(22, 34, 57, 0.85);
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            z-index: 1;
        }

        .caption h6 {
            font-size: 24px;
            font-weight: 300;
        }

        .caption h2 {
            font-size: 50px;
            font-weight: 700;
        }

        .comp-name-yellow {
            color: yellow;
            font-family:"Bodoni MT";
        }

        .comp-name-black {
            color: white;
            font-family:"Bodoni MT";
        }

        .main-button{
            margin-top:20px;
        }

        .main-button a {
            text-decoration: none;
            background-color: #ff7b00;
            color: white;
            padding: 12px 24px;
            border-radius: 4px;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        .main-button a:hover {
            background-color: #e66900;
        }

        .carousel-item {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 20px;
        }

        .comment-box {
            border: 2px solid #000;
            padding: 20px;
            border-radius: 10px;
            width: 30%;
            margin-top:30px;
            margin-left:300px;
        }

        .comment-box-2 {
            border: 2px solid #000;
            padding: 20px;
            border-radius: 10px;
            width: 30%;
            margin-top:30px;
            margin-left:900px;
        }

        .comment-box h5 {
            font-weight: bold;
        }

        .feature-container {
            display: flex;
            justify-content: center;
            gap: 70px;
            margin: 40px 0;
        }

        .card {
            position: relative;
            width: 350px;
            height: 400px;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-content {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 20px;
            transform: translateY(100%);
            transition: transform 0.4s ease-in-out;
        }

        .card:hover .card-content {
            transform: translateY(0);
        }

        .card-content h3 {
            margin: 0;
            font-size: 24px;
        }

        .card-content p {
            margin-top: 10px;
            font-size: 16px;
        }

        .why {
            margin: 0 0 50px;
  
            .title {
                font-size: 2.5rem;
                text-align: center;
                color: $color;
            }
  
            .menu {
                position: relative;
                list-style: none;
                padding: 0;
                display: flex;
                justify-content: space-between;
                margin: 100px auto 70px;
                max-width: 600px;
                
                &::after {
                    content: '';
                    position: absolute;
                    bottom: 4px;
                    left: 50%;
                    transform: translateX(-50%);
                    width: calc(100% - 100px);
                    height: 1px;
                    background-color: #eee;
                    z-index: -1;
                }
                
                li {
                    font-weight: 600;
                    line-height: 1.4;
                    text-align: center;
                    position: relative;
                    width: 100px;
                    color: #aaa;
                    cursor: pointer;
                
                    span {
                        position: absolute;
                        left: 0;
                        bottom: 30px;
                        width: 100%;
                    }
                
                    &::after,
                    &::before{
                        content: '';
                        position: absolute;
                        left: 50%;
                        transform: translateX(-50%);
                        border-radius: 50%;
                    }
                
                    &::after {
                        bottom: 0;
                        background-color: #aaa;
                        width: 10px;
                        height: 10px;
                    }
                
                    &::before {
                        bottom: -4px;
                        border: 2px solid #aaa;
                        width: 14px;
                        height: 14px;
                    }
                
                    &.active {
                        color: $color;
                        
                        &::before {
                        border-color: $color;
                        }
                        
                        &::after {
                        background-color: $color;
                        }
                    }
                }
            }
            .content {
                display: flex;
                
                @include atMaxMedium {
                flex-direction: column;
                }
                
                & > div {
                    width: 50%;
                    
                    @include atMaxMedium {
                        margin: auto;
                    }
                    
                    @include atMaxSmall {
                        width: 90%;
                    }
                }
            }
            .text {
                color: #555;
                padding: 0 30px;
                
                @include atMaxMedium {
                    margin-top: 40px !important;
                    }
                
                &__item {
                    display: none;
                
                    &.active {
                        display: block;
                    }
                }
            }
            
        .imgs {
            position: relative;
            min-height: 350px;
            
            @include atMaxMedium {
                min-height: 320px;
            }
                
            @include atMaxSmall {
                min-height: 220px;
            }
                
            img {
                display: block;
                max-width: 100%;
                height: 250px;
                border-radius: 7px;
                box-shadow: 0 15px 40px rgba(0,0,0,0.4);
                position: absolute;
                top: 0;
                left: 30px;
                z-index: 2;
                
                &.desactive {
                    top: 30px;
                    left: 0;
                    z-index: 1;
                }
            
                &.active {
                    top: 50px;
                    left: 50px;
                    z-index: 3;
                }
            }
        }
    }

    img.active--animation {
        animation-name: change;
        animation-duration: 2s;
        animation-fill-mode: forwards;
    }
    @keyframes change {
        0% {
        top: 50px;
        left: 50px;
        z-index: 4;
        }

        50% {
        top: 40px;
        left: 500px;
        z-index: 3;
        }

        100% {
        top: 30px;
        left: 0px;
        z-index: 0;
        }
    }

    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="hero-section">
        <video autoplay muted loop id="bg-video">
            <source src="video/trading_video_background.mp4" type="video/mp4" />
        </video>

        <div class="video-overlay header-text">
            <div class="caption">
                <h6>START YOUR TRADE HERE TODAY</h6>
                <h2>
                    <span class="comp-name-yellow">MY</span> 
                    <span class="comp-name-black">TRADE</span>
                </h2>
                <div class="main-button">
                    <a href="#section1">Discover more</a>
                </div>
            </div>
        </div>
    </div>

    <div class="feature-section">
    <h2 style="text-align: center; margin: 50px;">Key Features of Our Automated Forex Trading System</h2>

    <div class="feature-container">
        <!-- Card 1 -->
        <div class="card">
            <img src="picture/performance.jpg" alt="Performance">
            <div class="card-content">
                <h3>Optimized for Malaysian Traders</h3>
                <p>Tailored for local markets, ensuring smooth currency pairings (MYR included) with strategies designed for the unique trading hours and trends in Malaysia.</p>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="card">
            <img src="picture/usability.jpg" alt="Usability">
            <div class="card-content">
                <h3>User-Friendly and Intuitive</h3>
                <p>Our platform is designed for beginners and experts alike, offering simple interfaces with advanced trading tools to maximize your trading efficiency.</p>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="card">
            <img src="picture/analytics.jpg" alt="Analytics">
            <div class="card-content">
                <h3>Advanced Analytics and Automation</h3>
                <p>Track, analyze, and automate your trades effortlessly with real-time analytics and automated bots that execute trades on your behalf based on predefined strategies.</p>
            </div>
        </div>
    </div>
</div>


<section class="why">
  <div class="container">
    <h2 class="title">Why Choose Us?</h2>
    <ul class="menu">
      <li data-target="first"><span>Real-Time Forex Data</span></li>
      <li data-target="second"><span>User-Friendly Interface</span></li>
      <li data-target="third"><span>Customizable Portfolios</span></li>
    </ul>
    <div class="content">
      <div class="imgs">
        <img class="first-img" src="picture/real_time.jpg" alt="">
        <img class="second-img" src="picture/user_friendly.jpg" alt="">
        <img class="third-img" src="picture/portfolio.jpg" alt="">
      </div>
      <div class="text">
        <div class="text__item first-text">
          1. "Stay updated with live forex data sourced from trusted platforms, ensuring you always have the most accurate and up-to-date market information."
        </div>
        <div class="text__item second-text">
          2. "Our system is designed with simplicity in mind, providing an intuitive interface that makes managing your forex portfolio easy, even for beginners."
        </div>
        <div class="text__item third-text">
          3. "Create and manage your portfolio with ease. Set specific goals, track your progress, and view detailed reports on each currency pairing."
        </div>
      </div>
    </div>
  </div>
</section>

<section id="section1">
    <div id="commentCarousel" class="carousel slide" data-ride="carousel">
        <h1 style="margin:20px 0px 40px 40px">Feedback Section</h1>
        <div class="carousel-inner">
            <!-- Main Container 1 -->
                <div class="carousel-item active">
                    <div class="comment-box">
                        <h5>Jason Lim</h5>
                        <p>"I love how easy it is to set up and track my Forex portfolio using this platform. The 'My Portfolio' feature keeps everything in one place and helps me visualize my progress without the hassle. It's perfect for my investment goals!"</p>
                    </div>
                    <div class="comment-box-2">
                        <h5>Aishah Rahmang</h5>
                        <p>"The automated updates on live prices are fantastic. I feel more confident in making decisions because I can easily monitor changes without constantly switching between sites. The interface is clean, and I especially like the profit goal tracking!"</p>
                    </div>
                    <div class="comment-box">
                        <h5>Michael Tan</h5>
                        <p>"The system's simplicity makes it such a joy to use. Adding new currency pairings and setting goals is straightforward, and the visual profit/loss charts are a game changer for someone like me who's new to Forex tracking."</p>
                    </div>
                </div>

                <!-- Main Container 2 -->
                <div class="carousel-item">
                    <div class="comment-box">
                        <h5>Nurul Farhana</h5>
                        <p>"I appreciate the 'Why Choose Us' section. It really convinced me that this system was the right choice. It’s reassuring to know the thought that went into making this platform user-friendly and focused on our needs as beginners in portfolio management."</p>
                    </div>
                    <div class="comment-box-2">
                        <h5>Rajesh Kumar</h5>
                        <p>"The FAQ section answered all my questions before I even signed up. The member profile editing feature is well-designed, and I love that I can easily manage my account settings without worrying about data duplication. Well done!"</p>
                    </div>
                    <div class="comment-box">
                        <h5>David Lee</h5>
                        <p>"The 'My Portfolio' section is extremely intuitive and easy to use. I was able to set my investment goals and track live updates without any hassle. It's a great platform for anyone looking to manage their investments efficiently."</p>
                    </div>
                </div>

                <!-- Main Container 2 -->
                <div class="carousel-item">
                    <div class="comment-box">
                        <h5>Emily Wong</h5>
                        <p>"I feel in control of my investments, thanks to the goal-setting capabilities of this platform. The automated profit/loss calculations are so convenient and make tracking my progress seamless. I really recommend this system to anyone wanting a clear overview of their Forex activities."</p>
                    </div>
                    <div class="comment-box-2">
                        <h5>Sarah Tan</h5>
                        <p>"I love how the system provides detailed charts and analytics for my currency pairings. It makes tracking my investments so much easier and gives me a clear picture of my progress. Highly recommend it to anyone interested in Forex trading!"</p>
                    </div>
                    <div class="comment-box">
                        <h5>Arif Hassan</h5>
                        <p>"Setting up my profile and managing my portfolios was a breeze. The system's focus on preventing data duplication made me feel secure about my information. The overall experience has been smooth and stress-free!"</p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#commentCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color:black;"></span>
            </a>
            <a class="carousel-control-next" href="#commentCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true" style="background-color:black;"></span>
            </a>
    </div>
</section>

    <?php include("footer.php"); ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var menuItem = $('.why li'),
            imgItem = $('.why img'),
            textItem = $('.text__item');

        $('li:first-of-type').addClass('active');
        $('.text__item:first-of-type').addClass('active');
        $('.why img:first-of-type').addClass('active');
        $('.why img:last-of-type').addClass('desactive');

        menuItem.on('click', function(){
            menuItem.not($(this)).removeClass('active');
            textItem.not('.' + $(this).attr('data-target') + '-text').removeClass('active');
        
        if($('.' + $(this).attr('data-target') + '-img').hasClass('active')) {
            return;
        } else {
            imgItem.removeClass('active--animation');
            imgItem.removeClass('desactive');
            $('.why img.active').addClass('active--animation');
            $('.' + $(this).attr('data-target') + '-img').addClass('active');
            imgItem.not('.' + $(this).attr('data-target') + '-img').removeClass('active');
        }
        
        $(this).addClass('active');
        $('.' + $(this).attr('data-target') + '-text').addClass('active');
        });
    </script>
</body>
</html>