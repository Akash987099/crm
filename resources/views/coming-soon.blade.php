<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(to right, #00c6ff, #0072ff);
            color: white;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .coming-soon-container {
            text-align: center;
            padding: 20px;
            max-width: 600px;
        }
        .coming-soon-container h1 {
            font-size: 4rem;
            font-weight: bold;
        }
        .coming-soon-container p {
            font-size: 1.5rem;
        }
        .timer {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
        }
        .timer div {
            font-size: 2rem;
            font-weight: bold;
        }
        .timer div span {
            display: block;
            font-size: 1rem;
            font-weight: normal;
            color: #ddd;
        }
        .subscribe-form input {
            border-radius: 30px;
            padding: 10px 20px;
            margin-right: 10px;
            width: 300px;
            max-width: 80%;
            border: none;
        }
        .subscribe-form button {
            border-radius: 30px;
            padding: 10px 20px;
            border: none;
            background-color: #0056b3;
            color: white;
            cursor: pointer;
        }
        footer {
            margin-top: 30px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="coming-soon-container">
        <h1>Coming Soon</h1>
        <p>Our website is under construction. We are working hard to give you the best experience.</p>

        <!-- Timer Section -->
        <div class="timer">
            <div>
                <span id="days">00</span>
                <span>Days</span>
            </div>
            <div>
                <span id="hours">00</span>
                <span>Hours</span>
            </div>
            <div>
                <span id="minutes">00</span>
                <span>Minutes</span>
            </div>
            <div>
                <span id="seconds">00</span>
                <span>Seconds</span>
            </div>
        </div>

        <!-- Email Subscription Section -->
        <form class="subscribe-form mt-4">
            <input type="email" placeholder="Enter your email" required>
            <button type="submit">Notify Me</button>
        </form>

        <!-- Footer -->
        <footer>
            &copy; 2024 AWS Connect. All Rights Reserved.
        </footer>
    </div>

    <!-- Bootstrap JS and Countdown Timer Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Countdown Timer Function
        function countdown() {
            const targetDate = new Date("Dec 31, 2024 23:59:59").getTime();
            const timer = setInterval(function() {
                const now = new Date().getTime();
                const distance = targetDate - now;

                // Time calculations for days, hours, minutes and seconds
                const days = Math.floor(distance / (10000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Output the result
                document.getElementById("days").innerHTML = days;
                document.getElementById("hours").innerHTML = hours;
                document.getElementById("minutes").innerHTML = minutes;
                document.getElementById("seconds").innerHTML = seconds;

                // If the countdown is over, stop the timer
                if (distance < 0) {
                    clearInterval(timer);
                    document.querySelector('.timer').innerHTML = "We're live!";
                }
            }, 1000);
        }
        countdown();
    </script>
</body>
</html>
