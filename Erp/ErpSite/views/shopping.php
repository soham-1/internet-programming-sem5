<!DOCTYPE html>
<html lang="en">

<?php
    require 'includeCDN.php';
    require 'welcome.php';
    require '../models/connDB.php';
?>

<head>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/shopping.css">
</head>

<?php
    // $products = $conn->query("
    // SELECT * FROM products
    // WHERE product_id IN
    // (SELECT MIN(product_id) FROM products GROUP BY category)");
    $products = $conn->query("select * from products order by category");
    $category_list = $conn->query("select distinct category from products");
    $category_array = array();
    while($row=$category_list->fetch_assoc()) {
        $all_prod = $conn->query("select * from products where category='{$row['category']}' limit 4");
        array_push($category_array, array("label" => $row['category'], "mysqli_res" => $all_prod));
    }

    $clothes = $conn->query("select * from products where category='clothes' ");
    $daily_items = $conn->query("select * from products where category='daily' ");
?>

<body>
<div class="outer-container">
    <div class="row col-lg-6 col-md-4 col-sm-11" id="popular">
    <!-- <i class="fas fa-angle-left angle"></i> -->
    <button class="prev" disabled>prev</button>
    <?php
    while($row=$products->fetch_assoc()) {
        if (isset($row['image'])) {
        echo '<div class="card col-lg-2 col-md-6 col-sm-11">
                <a href="shop_list.php?product_id='. $row['product_id'] . '">
                <img src="data:image/png;charset=utf8;base64,' . base64_encode($row['image']) . '" alt="image not available" style="width:100%">
                </a>
                <div class="text-container">
                    <h4><b>'. $row['name'] .'</b></h4>
                    <p>'. $row['category'] .'</p>
                </div>
              </div>
              ';
        } else {
            echo '<div class="card col-lg-2 col-md-4 col-sm-11">
                <a href="shop_list.php?product_id='. $row['product_id'] . '">
                <img src="css/defaultC.png" alt="image not available" style="width:100%">
                </a>
                <div class="text-container">
                    <h4><b>'. $row['name'] .'</b></h4>
                    <p>'. $row['category'] .'</p>
                </div>
              </div>';
        }
    }
    ?>
    <div class="card col-lg-2 col-md-4 col-sm-6">
                <img src="css/defaultC.png" alt="Avatar" style="width:100%">
                <div class="text-container">
                    <h4><b>3</b></h4>
                    <p>dummy values</p>
                </div>
              </div>
              <div class="card col-lg-2 col-md-4 col-sm-6">
                <img src="css/defaultC.png" alt="Avatar" style="width:100%">
                <div class="text-container">
                    <h4><b>4</b></h4>
                    <p>dummy values</p>
                </div>
              </div>

              <div class="card col-lg-2 col-md-4 col-sm-6">
                <img src="css/defaultC.png" alt="Avatar" style="width:100%">
                <div class="text-container">
                    <h4><b>5</b></h4>
                    <p>dummy values</p>
                </div>
              </div>
              <div class="card col-lg-2 col-md-4 col-sm-6">
                <img src="css/defaultC.png" alt="Avatar" style="width:100%">
                <div class="text-container">
                    <h4><b>6</b></h4>
                    <p>dummy values</p>
                </div>
              </div>
              <div class="card col-lg-2 col-md-4 col-sm-6">
                <img src="css/defaultC.png" alt="Avatar" style="width:100%">
                <div class="text-container">
                    <h4><b>7</b></h4>
                    <p>dummy values</p>
                </div>
              </div>
              <div class="card col-lg-2 col-md-4 col-sm-6">
                <img src="css/defaultC.png" alt="Avatar" style="width:100%">
                <div class="text-container">
                    <h4><b>8</b></h4>
                    <p>dummy values</p>
                </div>
              </div>
              <!-- <span class="angle"><i class="fas fa-angle-right"></i></span> -->
              <button class="next" >next</button>
    </div><br>

    <?php 
        for ($i=0; $i<count($category_array); $i++) {
            $category = $category_array[$i]['mysqli_res'];
            echo '<a href="category_list.php?category='.$category_array[$i]['label'].'" id="category-title"><h2>'.$category_array[$i]['label'] .'</h2></a>
            <div class="row col-lg-8 col-md-4 col-sm-11" id="category">';
            while($row=$category->fetch_assoc()) {
                if (isset($row['image'])) {
                echo '<div class="card col-lg-2 col-md-4 col-sm-12">
                        <a href="shop_list.php?product_id='. $row['product_id'] . '">
                            <img src="data:image/png;charset=utf8;base64,' . base64_encode($row['image']) . '" alt="image not available" style="width:100%">
                        </a>
                        <div class="text-container">
                            <h4><b>'. $row['name'] .'</b></h4>
                        </div>
                    </div>';
                } else {
                    echo '<div class="card col-lg-2 col-md-4 col-sm-12">
                        <a href="shop_list.php?product_id='. $row['product_id'] . '">
                            <img src="css/defaultC.png" alt="Avatar" style="width:100%">
                        </a>
                        <div class="text-container">
                            <h4><b>'. $row['name'] .'</b></h4>
                        </div>
                    </div>';
                }
            }
            echo '</div>';
        }
    ?>
</div>
</body>
<script>
// script for slide show
    let count = 0;
    let visible_items;
    let num_slides;
    let element = $('#popular .card');
    if (screen.width<=600) {
        visible_items=1;
    } else if (screen.width>600 && screen.width<=768) {
        visible_items=3;
    } else if (screen.width>768) {
        visible_items=4;
    }

    for (i=0; i<element.length; i++) {
        element[i].style.display = "none";
    }
    if (element.length%visible_items==0) {
        num_slides = Math.floor(element.length/visible_items);
    } else {
        num_slides = Math.floor(element.length/visible_items) + 1;
    }
    $('.prev').click(function() {
        count -= 1;
        $('.next')[0].disabled = false;
        if (count<=0)
            this.disabled = true ;
        for (i=0; i<element.length; i++) {
            // element[i].addClass ("translate-backward");
            // element[i].style.transition = "all 3s";
            // element[i].style.transform = "translateX(-100%)";
        }
    });

    $('.next').click(function() {
        count += 1;
        $('.prev')[0].disabled = false;
        if (count>=(num_slides-1))
            this.disabled = true ;
        for (i=0; i<element.length; i++) {
            // element[i].addClass ("translate-forward");
            // element[i].style.transition = "all 3s";
            // element[i].style.transform = "translateX(100%)";
        }
    });

    $('button').click(function() {
        for (i=0; i<element.length; i++) {
            if (i>=(count*visible_items) && i<((count+1)*visible_items)) {
                console.log(element[i]);
                element[i].style.display = "block";
            } else {
                element[i].style.display = "none";
            }
        }
    });
    for (i=0; i<visible_items; i++) {
        element[i].style.display = "block";
    }
    $('.fa-angle-right').bind("click", function() {
        $('.next').trigger('click');
    });
    $('.fa-angle-left').bind("click", function() {
        $('.prev').trigger('click');
    });
</script>
</html>