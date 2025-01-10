<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assetica - Solusi Aset Premium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite('resources/css/styles.css')

</head>

<body>


    <div class="content">
         @yield('content')
    </div>

    <!-- Footer Section -->
    <footer class="footer">
        <!-- Left Section -->
        <div class="footer-left">
            <h2>
                <a href="/">
                    <img src="/storage/uploads/logo/white.png" alt="LOGO" class="navbar-brand">
                </a>
            </h2>

            <p>Send me tips, trends, freebies,<br>updates & offers.</p>
            <div class="social-icons">
                <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/6/6f/Logo_of_Twitter.svg"
                        alt="X"></a>
                <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png"
                        alt="Instagram"></a>
                <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/6/6c/Facebook_Logo_2023.png"
                        alt="Facebook"></a>
                <a href="#"><img
                        src="https://upload.wikimedia.org/wikipedia/commons/4/42/YouTube_icon_%282013-2017%29.png"
                        alt="YouTube"></a>
            </div>
        </div>

        <!-- Right Section -->
        <div class="footer-right">
            <strong>Hak Cipta © 2024 Assetica</strong>
            <span>Seluruh konten yang terdapat dalam website ini<br>dilindungi oleh undang-undang hak cipta</span>
        </div>
    </footer>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/js/scripts.js')

</body>

</html>
