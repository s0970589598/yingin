

<html>
    <head>
        <link rel="stylesheet" href="../css/leading.css" />
        <link rel="stylesheet" href="../css/menu.css" />
    </head>
    <body>
        <div class="wrapper">
            <div class="menu-container" id="toggle">
                <a href="#" class="menu"><i class="fa fa-bars" aria-hidden="true"></i></a>
            </div>
            <div class="overlay" id="overlay">
                <nav class="overlay-menu">
                    <ul>
                    <li><a href="namefate.php">姓名鑑定</a></li>
                    <li><a href="nameing.php">姓名配對</a></li>
                    <li><a href="conamefate.php">公司名鑑定</a></li>
                    <li><a href="conameing.php">公司名配對</a></li>
                    <li><a href="numfate.php">萬數鑑定</a></li>
                    </ul>
                </nav>
            </div>
            <div class="container">
                <h1>公司名配對</h1>
                <div class="loader">
                    <div class="inner one"></div>
                    <div class="inner two"></div>
                    <div class="inner three"></div>
                </div>
                <form class="form" action="showconameing.php" method="post">
                    <input type="text" name="count" placeholder="公司簡稱字數">
                    <input type="text" name="first_num"  placeholder="網路行銷股份有限公司">
                    <button type="submit" id="login-button">確認</button>
                </form>
            </div>

            <ul class="bg-bubbles">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
        <!-- Javascript -->
        <script src="../js/jquery.min.js"></script>
        <script>
            // menu
            const menu = document.querySelector("#toggle");
            const menuItems = document.querySelector("#overlay");
            const menuContainer = document.querySelector(".menu-container");
            const menuIcon = document.querySelector("i");

            function toggleMenu(e) {
                menuItems.classList.toggle("open");
                menuContainer.classList.toggle("full-menu");
                menuIcon.classList.toggle("fa-bars");
                menuIcon.classList.add("fa-times");
                e.preventDefault();
            }
            menu.addEventListener("click", toggleMenu, false);

            // loading
            document.getElementsByClassName('loader')[0].style.display = 'none';
            $("#login-button").click(function(event){
                //event.preventDefault();
                document.getElementsByClassName('loader')[0].style.display = 'block';
                //$('form').fadeOut(500);
                //$('.wrapper').addClass('form-success');
            });
        </script>
    </body>
</html>
