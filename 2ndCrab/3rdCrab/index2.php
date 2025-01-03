<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>crab clicker</title>
    <link rel="stylesheet" type="text/css" href="../static/style.css" />

</head>
<header>

</header>

<body>
    <div id="tempElements"></div>

    <div id="tempElements"></div>


    <div class="nav">

        <img src="../images/profile.jpg" class="profile" id="userProfile">

        <form name="saveForm" action="../save.php" method="post" class="save">
            <input type="hidden" id="crabCount" name="crabCount" value="0">
            <input type="hidden" id="firstCount" name="firstCount" value="0">
            <input type="hidden" id="secondCount" name="secondCount" value="0">
            <input type="hidden" id="thirdCount" name="thirdCount" value="0">
            <input type="hidden" id="fourthCount" name="fourthCount" value="0">
            <input type="hidden" id="fithCount" name="fithCount" value="0">
            <button type="submit" id="save"><img class="profile" src="../images/save.png" alt="save"></button>
            <!-- <input type="submit" id="save" value="Save"> -->
        </form>


        <img src="../images/leaderboardpic.png" class="leaderBoard" id="gobalStats">
        <div id="gobalStatsPage" class="statsContainer hidden">
            <h1>Leader</h1><span>
                <h1>Board</h1>
            </span>
            <div>
                <?php
                if (isset($_SESSION['topCrabs'])) {

                    foreach ($_SESSION['topCrabs'] as $row) {
                        $temparra = $row;
                        echo "<p class='lbName'>" . $temparra["username"] . "</p>" . "  " ."<p class='lbCrabs'>" . $temparra["crabs"] . "</p>" ;        
                    }
                }
                ?>
            </div>

            <button  onclick="reloadLB()">refresh</button>

        </div>


    </div>



    <!-- login menu -->
    <div id="loginPage" class="loginContainer hidden <?php if (isset($_SESSION["error"])) {
                                                            echo "show";
                                                        } ?>">
        <h1>Logged in</h1>

        <?php
        // Error flash success
        if (isset($_SESSION["success"])) {
            echo ('<p style="color:green">' . $_SESSION["success"] . "</p>\n");
            unset($_SESSION["success"]);
        }
if (isset($_SESSION["account"])) {
    echo ('<p style="color:green">' . "Welcome back " . $_SESSION["username"] . "</p>\n");
}
        // Error flash message
        if (isset($_SESSION["error"])) {
            echo ('<p style="color:red">' . $_SESSION["error"] . "</p>\n");
            unset($_SESSION["error"]);
        }

        // If account was not set then the user is not logged in so we display login form
        if (!isset($_SESSION["account"])) { ?>
            <form name="loginForm" action="../login.php" method="post" class="show">
                <input type="text" name="Email" id="Email" placeholder="Email or Username" minlength="2" maxlength="50" value="" required>
                <!-- the above input name refers to ether the email or username  -->
                <br>
                <br>
                <input type="password" name="Password" id="Password" placeholder="Password" minlength="8" maxlength="255" value="" required>
                <br>
                <br>
                <input type="submit" id="submitLogin" value="Login">

            </form>

            <form name="signUpForm" action="../signUp.php" method="post" class="hidden">
                <input type="hidden" id="crabCount" name="crabCount" value="0">
                <input type="hidden" id="firstCount" name="firstCount" value="0">
                <input type="hidden" id="secondCount" name="secondCount" value="0">
                <input type="hidden" id="thirdCount" name="thirdCount" value="0">
                <input type="hidden" id="fourthCount" name="fourthCount" value="0">
                <input type="hidden" id="fithCount" name="fithCount" value="0">

                <input type="text" name="newUsername" id="newUsername" placeholder="Username" minlength="2" maxlength="50" value="" required>
                <br>
                <br>
                <input type="text" name="newEmail" id="newEmail" placeholder="Email" minlength="2" maxlength="50" value="" required>
                <br>
                <br>
                <input type="password" name="newPassword" id="newPassword" placeholder="Password" minlength="8" maxlength="255" value="" required>
                <br>
                <br>
                <input type="submit" id="submitSignUp" value="SignUp">
            </form>
            <p id="signUpText">Don't have an account? <span> <button id="signUpButton">SignUp</button> </span> </p>
        <?php } else { ?>
            <p>This is where a cool application would be.</p>
            <p>Please <a href="../logout.php">Log Out</a> when you are done.</p>
        <?php } ?>


    </div>

    <br>
    <h1>click him</h1>
    <span class="box">
        <img src="../images/crab_by_themarioman56_ddzpij5-fullview.png" alt="crabclicker" id="crab" onclick="updateCounter()">
    </span>
    <span id="input-El" class="inputP"><?php echo $_SESSION["crabs"] ?></span>
    <span id="crabSec" class="inputP">0</span>
    <div class="container" id="itemContainer">
        <div class="buy1">
            <h2>coral</h2>
            <p>1 crab every 1second</p>
            <p id="firstItemCount"><?php echo $_SESSION["firstItem"]; ?></p>
            <button id="firstItem">Buy <span>30 crabs</span></button>
        </div>
        <div class="buy2">
            <h2>sea salt</h2>
            <p>3 crab every 1second</p>
            <p id="secondItemCount"><?php echo $_SESSION["secondItem"] ?></p>
            <button id="secondItem">Buy<span>45 crabs</span></button>
        </div>
        <div class="buy3">
            <h2>net</h2>
            <p>5 crab every 1second</p>
            <p id="thirdItemCount"><?php echo $_SESSION["thirdItem"] ?></p>
            <button id="thirdItem">Buy<span>60 crabs</span></button>
        </div>
        <div class="buy4">
            <h2>boat</h2>
            <p>8 crab every 1second</p>
            <p id="fourthItemCount"><?php echo $_SESSION["fourthItem"] ?></p>
            <button id="fourthItem">Buy<span>100 crabs</span></button>
        </div>
        <div class="buy5">
            <h2>cage</h2>
            <p>15 crab every 1second</p>
            <p id="fithItemCount"><?php echo $_SESSION["fithItem"] ?></p>
            <button id="fithItem">Buy<span>250 crabs</span></button>
        </div>
    </div>



    <h1 class="chat" id="userChat">media</h1>
    <div id="chatPage" class="chatContainer hidden">
        <h1>Worked</h1><Span><h1> Cited</h1></Span>
        <ul>
            <li>
                <p>Wikimedia Commons. <a target="_blank" href="https://commons.wikimedia.org/wiki/File:Topeka-leaderboard_cropped.png"> "File:Topeka-leaderboard cropped.png."</a> <em>Wikipedia, The Free Encyclopedia</em>. Wikipedia, The Free Encyclopedia, 17 September 2020. </p>
            </li>
            <li><p>Nordborg, Mikaela. “Researchers Embrace a Radical Idea: Engineering Coral to Cope with Climate Change,”<em> Science</em>. 21 Mar. 2019, <a target="_blank" href="https://www.science.org/content/article/researchers-embrace-radical-idea-engineering-coral-cope-climate-change">www.science.org/content/article/researchers-embrace-radical-idea-engineering-coral-cope-climate-change.</a></p></li>
            <li><p>"<a target="_blank" href="https://www.deviantart.com/themarioman56/art/Crab-846037265">Crab</a>" by <a target="_blank" href="https://www.deviantart.com/themarioman56/gallery">themarioman56</a> is licenesd under <a target="_blank" href="https://creativecommons.org/licenses/by-sa/3.0/">CC BY-SA 3.0</a></p></li>
            <li><p>black white. <a target="_blank" href="https://blackwhite.pictures/image/fishing-boat-sunset-silhouette-fisherman-golden-glow-dawn-water-sunrays-gambar-siluet-mancing-nelayan-orang-489">fishing boat sunset silhouette fisherman golden glow dawn water sunrays gambar siluet mancing nelayan orang free black and white image</a>. 2023</p></li>
            <li><p>"<a target="_blank" href="https://www.pexels.com/photo/salt-pans-on-the-shore-18489579/">Salt Pans on the Shore
            </a>" by <a target="_blank" href="https://www.pexels.com/@bluemix/">Abdulmomen Bsruki</a> is licenesd under <a target="_blank" href="https://www.pexels.com/license/">Pexels</a>
            </a> </p></li>
            <li><p>"<a target="_blank" href="https://www.pexels.com/photo/food-healthy-fishing-sea-8352379/">Sealife in a net 
            </a>" by <a target="_blank" href="https://www.pexels.com/@kindelmedia/"> Kindel Media</a> is licenesd under <a target="_blank" href="https://www.pexels.com/license/">Pexels</a>
            </a> </p></li>
            <li><p>"<a target="_blank" href="https://pxhere.com/en/photo/639785">Boats on ocean
            </a>"is licenesd under <a target="_blank" href="https://creativecommons.org/publicdomain/zero/1.0/">CC0 1.0</a> </p></li>
            <li><p>“Bag O' Crab.” <em>Bag O'Crab</em>, 2021, <a target="_blank" href="https://www.bagocrabusa.com/">www.bagocrabusa.com/</a>.</p></li>
            <li><p>"<a target="_blank" href="https://creazilla.com/media/clipart/7805356/floppy-disk">Floppy disk clipart</a>" by <a target="_blank" href="https://gahag.net/">gahag.net</a> is licenesd under <a target="_blank" href="https://creativecommons.org/publicdomain/zero/1.0/">CC0 1.0</a></p></li>
           
            <li><p>"<a target="_blank" href="https://pikwizard.com/photo/ripples-in-sand-desert-surface-for-background-texture/44d8ba6f20108d08e7e37056035c65e5/">Ripples in Sand Desert Surface for Background Texture Image</a>" by <a target="_blank" href="https://pikwizard.com/">PikWizard</a> is licenesd under <a target="_blank" href="https://creativecommons.org/publicdomain/zero/1.0/">CC0 1.0</a></p></li>
                <li><p>"<a target="_blank" href="https://pixabay.com/sound-effects/button-pressed-38129/">button-pressed</a>" by <a target="_blank" href="https://pixabay.com/users/freesound_community-46691455/">StavSounds (Freesound)</a> is liscenesd under <a target="_blank" href="https://pixabay.com/service/license-summary/">pixabay</a></p></li>
                <li><p>"<a target="_blank" href="https://pixabay.com/sound-effects/notification-2-269292/">notification 2</a>" by <a target="_blank" href="https://pixabay.com/users/rasoolasaad-47313572/">RasoolAsaad</a> is liscenesd under <a target="_blank" href="https://pixabay.com/service/license-summary/">pixabay</a></p></li>      
            </ul>
    </div>


<!-- <form action="../leaderboard.php">
    <button type="submit">diwajdioawjdawiojdawiojdawoidj</button>
</form> -->



    <script src="../new.js" defer></script>
</body>
<footer></footer>

</html>