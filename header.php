<header>
    <div class="h-top">
        <div class="container">
            <a href="index.html"><img src="./assets/img/logo.png" alt="Logo"><span>Lo-Ly Twins</span></a>
        </div>
    </div>
    <div class="h-down">
        <div class="container">
            <ul class="nav">
                <?php
                $sql1 = "SELECT * FROM TownCity";
                $result1 = $conn->query($sql1);

                if ($result1->num_rows > 0) {
                    while ($row1 = $result1->fetch_assoc()) {
                        $active = 'active';
                        $active = ($row1['CityID'] == $city_id) ? 'active' : '' ;
                        echo '<li>
                            <a href="index.php?city='.$row1['CityID'].'" class="btn '.$active.'">'.$row1['Name'].'</a>
                        </li>';
                    }
                }
                ?>
                <li>
                    <a href="rss.php" class="btn">RSS Feed</a>
                </li>
            </ul>
        </div>
    </div>
</header>