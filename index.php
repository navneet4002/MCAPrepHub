
<?php 
session_start();
include("includes/header.php"); 
?>

<div class="layout">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <h3>Quick Access</h3>

        <a href="index.php">Home</a>
        <a href="dashboard.php">Tests</a>
        <a href="study.php">Study Material</a>
        <a href="performance.php">Performance</a>
        <a href="contact.php">Contact Us</a>

        <?php if(isset($_SESSION['user'])){ ?>
            <a href="logout.php">Logout</a>
        <?php } ?>

    </div>

     <div class="main index-page">        

    <div class="home-container">

    <?php
    date_default_timezone_set("Asia/Kolkata");

    $hour = date("H");

    if($hour < 12){
        $greeting = "Good Morning";
    }
    else if($hour < 17){
        $greeting = "Good Afternoon";
    }
    else{
        $greeting = "Good Evening";
    }

    $name = isset($_SESSION['name']) ? $_SESSION['name'] : "Guest";

    // Quotes
    $quotes = [
    "Success doesn’t come from what you do occasionally, but what you do consistently.",
    "Push yourself, because no one else is going to do it for you.",
    "Dream big. Start small. Act now.",
    "Discipline is the bridge between goals and achievement.",
    "Consistency beats talent when talent doesn’t work hard."
    ];

    $quote = $quotes[array_rand($quotes)];
    ?>

    <!-- HERO -->
    <div class="card welcome-card">

        <h2><?php echo $greeting; ?>, <?php echo ucfirst($name); ?> 👋</h2>

        <p>
            Start your journey today! Take your first test and unlock your potential.
        </p>

        <div class="welcome-actions">

            <a href="dashboard.php">
                <button class="btn">📘 Start Test</button>
            </a>

            <a href="performance.php">
                <button class="btn">📊 View Performance</button>
            </a>

        </div>

    </div>

    <!-- MOTIVATION -->
    <div class="card">

        <h3>💡 Daily Motivation</h3>

        <p style="font-style:italic;">
            "<?php echo $quote; ?>"
        </p>

    </div>

    <!-- FEATURES -->
    <div class="card">

        <h3>🚀 Why Choose MCAPrepHub?</h3>

        <div class="features-grid">

            <div class="feature">
                <h4>📊 Smart Analysis</h4>
                <p>Get detailed insights of your performance after every test.</p>
            </div>

            <div class="feature">
                <h4>🎯 Targeted Practice</h4>
                <p>Practice topic-wise questions and strengthen weak areas.</p>
            </div>

            <div class="feature">
                <h4>⏱ Real Exam Interface</h4>
                <p>Experience real exam environment with timer and navigation.</p>
            </div>

        </div>

    </div>

    <!-- PROGRESS -->
    <div class="card">

        <h3>📈 Your Journey Starts Here</h3>

        <p>
            Take regular tests, analyze your mistakes, and improve daily. 
            Consistency is the key to cracking MCA entrance exams.
        </p>

    </div>

    <!-- ABOUT -->
    <div class="about-wrapper">

        <div class="card about-main">

            <h2>About MCAPrepHub</h2>

            <p class="about-intro">
                MCAPrepHub is a smart and student-focused online platform designed to help aspirants prepare for MCA entrance exams like 
                <b>NIMCET</b>, <b>CUET-PG</b>, and other competitive tests.
            </p>

            <p class="about-intro">
                We combine structured mock tests, topic-wise practice, and detailed performance analysis to help you improve consistently.
            </p>

            <p class="about-intro">
                Our system tracks your progress and helps you focus on improving accuracy, speed, and confidence.
            </p>

            <div class="about-features">

                <div class="feature-box">📘 Full-Length Mock Tests</div>
                <div class="feature-box">🧠 Subject-wise Practice</div>
                <div class="feature-box">📊 Performance Analytics</div>
                <div class="feature-box">⏱ Real Exam Experience</div>

            </div>

        </div>

    </div>

    </div> <!-- home-container -->

    </div> <!-- main -->

</div> <!-- layout -->

<?php include("includes/footer.php"); ?>

