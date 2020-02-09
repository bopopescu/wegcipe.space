<?php require 'head.php'; ?>

<body style="margin:0;" style="background-image: url('./resources/cooking.jpg');">
    <!--Navbar section-->
    <nav class="navbar navbar-light bg-light">
        <a href="https://www.wegmans.com/">
        <img src="./resources/WegmansLogo.min.svg" width="190" height="75" alt="logo"></img>
        </a>
        <ul>
            <li><a href="">Search Recipes</a></li>
            <li><a href="https://shop.wegmans.com/shop/recipes">Recipe Suggestions</a></li>
            <li><a href="https://shop.wegmans.com/list/review">Cart</a></li>
        </ul>
    </nav>
    <div class="card card-block w-50" position="absolute" style="top: 220px; left:25%;">
        <ul class="list-group list-group-flush">
        <?php 
                    if(isset($_SESSION["username"])){
                    if (isset($_POST['del'])) {
                        $query = "SELECT * FROM users WHERE username='".$_SESSION['username']."'";
                        $usersResult = $db->query($query);
                        while($userRow = $usersResult->fetch_assoc()){
                            if($userRow['cal1course1']==$_POST['del']){
                                $delEntry="UPDATE users SET cal1course1 = NULL WHERE username='".$_SESSION['username']."'";
                            }
                            elseif($userRow['cal1course2']==$_POST['del']){
                                $delEntry="UPDATE users SET cal1course2 = NULL WHERE username='".$_SESSION['username']."'";
                            }
                            elseif($userRow['cal1course3']==$_POST['del']){
                                $delEntry="UPDATE users SET cal1course3 = NULL WHERE username='".$_SESSION['username']."'";
                            }
                            elseif($userRow['cal1course4']==$_POST['del']){
                                $delEntry="UPDATE users SET cal1course4 = NULL WHERE username='".$_SESSION['username']."'";
                            }
                            elseif($userRow['cal1course5']==$_POST['del']){
                                $delEntry="UPDATE users SET cal1course5 = NULL WHERE username='".$_SESSION['username']."'";
                            }
                            elseif($userRow['cal1course6']==$_POST['del']){
                                $delEntry="UPDATE users SET cal1course6 = NULL WHERE username='".$_SESSION['username']."'";
                            }
                            else{
                                $delEntry="UPDATE users SET cal1course7 = NULL WHERE username='".$_SESSION['username']."'";
                            }
                        }
                        if(!$db->query($delEntry)) {
                            echo $mysqli->error;               
                        } }
                    $sql = "SELECT * FROM users WHERE username LIKE '".$_SESSION['username']."'";
                    $courseList = $db->query($sql);}
                    // while($rowInUsers = $courseList->fetch_assoc()){
                    //     foreach ($rowInUsers as $k => $v){
                    //         if(($k=='cal1course1' || $k=='cal1course2' || $k=='cal1course3' || $k=='cal1course4' || $k=='cal1course5' || $k=='cal1course6' || $k=='cal1course7') && $v!=''){
                    //             $query="SELECT * FROM schedule WHERE courseID LIKE '$v'";
                    //             $course = $db->query($query);
                    //             while($row = $course->fetch_assoc()){
                        ?>
            <li class="list-group-item">Cras justo odio</li>
            <li class="list-group-item">Dapibus ac facilisis in</li>
            <li class="list-group-item">Vestibulum at eros</li>
        </ul>
    </div>

    <script src="./index.js">
    </script>
</body>
</html>