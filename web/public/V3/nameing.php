

<html>
    <head>
        <link rel="stylesheet" href="../css/leading.css" />
    </head>
    <body>

        <div class="wrapper">
            <div class="container">
                <h1>姓名配對</h1>
                <div class="loader">
                    <div class="inner one"></div>
                    <div class="inner two"></div>
                    <div class="inner three"></div>
                </div>
                <form class="form" action="shownameing.php" method="post">
                    <input type="text" name="first_num" placeholder="姓氏筆劃">
                    <input type="text" name="count"  placeholder="字數">
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
        document.getElementsByClassName('loader')[0].style.display = 'none';
        $("#login-button").click(function(event){
        //        event.preventDefault();
        document.getElementsByClassName('loader')[0].style.display = 'block';
            //$('form').fadeOut(500);
            //$('.wrapper').addClass('form-success');
        });
    </script>

    </body>
</html>
