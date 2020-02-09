<?php require 'head.php'; ?>
<body style="margin:0;" style="background-image: url('./resources/cooking.jpg');">
    <!--Navbar section-->
    <nav class="navbar navbar-light bg-light">
        <a href="https://www.wegmans.com/">
        <img src="./resources/WegmansLogo.min.svg" height="60" alt="logo"></img>
        </a>
        <!-- <ul>
            <li class="p-0 pr-5 align-bottom"><a href="https://shop.wegmans.com/shop/recipes">Recipe Suggestions</a></li>
            <li class="p-0 align-bottom"><a href="https://shop.wegmans.com/list/review">Cart</a></li>
        </ul> -->
    </nav>
    <?php if (!isset($_POST['submit'])) {?>
    <div>
        <form method="post">
            <div class="card card-block w-50" position="absolute" style="top: 220px; left:25%;">
                <div class="card-body pb-2">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-8 m-0">
                                <input type="text" class="form-control" name="recipelink" id="recipelink" placeholder="Recipe link here">
                            </div>
                            <div class="w-10 m-0 p-0">
                                <label for="servingsize" class="p-0 align-bottom m-2">Servings:</label>
                            </div>
                            <div class="mr-3">
                                <select class="form-control p-0" id="servingsize">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                            <div class="m-0">
                                <button type="button " class="btn btn-dark" type="submit" name="submit" id="submit" value="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div> <?php } 
    else {
        $data = $_POST['recipelink'];
        $result = shell_exec("python3 ./python/recipeParser/Parser.py " . escapeshellarg($data));

        $in = filter_input(INPUT_GET, $_POST['recipelink'], FILTER_VALIDATE_INT);
        $command = "python3 ./python/recipeParser/Parser.py .$in";
        $python = "$command";
        echo $python; 

        $item = $_POST['recipelink'];
        $tmp = shell_exec("python3 ./python/recipeParser/Parser.py .$item");
        echo $tmp;

        $command = escapeshellcmd("python3 ./python/recipeParser/Parser.py .$item");
        $output = shell_exec($command);
        echo $output;
    
        ?>
    <div class="card card-block w-50" position="absolute" style="top: 220px; left:25%;">
        <ul class="list-group list-group-flush">
        <?php 
            $query = "SELECT * FROM selections";
            $usersResult = $db->query($query);
            while($userRow = $usersResult->fetch_assoc()){
                ?>
                <li class="list-group-item"> 
                        <?php foreach ($userRow as $k => $v){ echo "$k: $v | ";
                    } ?>
                </li>
            <?php }?>
        </ul>
    </div>
    <?php } ?>

    <script src="./index.js">
    </script>
</body>

<?php 
    print_r($_POST);
?>

</html>

<!--<a href="./results.php" style="color: inherit;">->
<?php 
// if($userRow['cal1course1']==$_POST['del']){
//     $delEntry="UPDATE users SET cal1course1 = NULL WHERE username='".$_SESSION['username']."'";
// }
// elseif($userRow['cal1course2']==$_POST['del']){
//     $delEntry="UPDATE users SET cal1course2 = NULL WHERE username='".$_SESSION['username']."'";
// }
// elseif($userRow['cal1course3']==$_POST['del']){
//     $delEntry="UPDATE users SET cal1course3 = NULL WHERE username='".$_SESSION['username']."'";
// }
// elseif($userRow['cal1course4']==$_POST['del']){
//     $delEntry="UPDATE users SET cal1course4 = NULL WHERE username='".$_SESSION['username']."'";
// }
// elseif($userRow['cal1course5']==$_POST['del']){
//     $delEntry="UPDATE users SET cal1course5 = NULL WHERE username='".$_SESSION['username']."'";
// }
// elseif($userRow['cal1course6']==$_POST['del']){
//     $delEntry="UPDATE users SET cal1course6 = NULL WHERE username='".$_SESSION['username']."'";
// }
// else{
//     $delEntry="UPDATE users SET cal1course7 = NULL WHERE username='".$_SESSION['username']."'";
// }
// }
// if(!$db->query($delEntry)) {
// echo $mysqli->error;               
// } }
// $sql = "SELECT * FROM users WHERE username LIKE '".$_SESSION['username']."'";
// $courseList = $db->query($sql);}
// while($rowInUsers = $courseList->fetch_assoc()){
//     foreach ($rowInUsers as $k => $v){
//         if(($k=='cal1course1' || $k=='cal1course2' || $k=='cal1course3' || $k=='cal1course4' || $k=='cal1course5' || $k=='cal1course6' || $k=='cal1course7') && $v!=''){
//             $query="SELECT * FROM schedule WHERE courseID LIKE '$v'";
//             $course = $db->query($query);
//             while($row = $course->fetch_assoc()){
    ?>