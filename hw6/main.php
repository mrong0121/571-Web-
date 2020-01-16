<!DOCTYPE html>
<?php
$readyLocation = 0;
$lat = "";
$lon = "";
$keyword = "";
$condition =[];
$category = "";
$shippingOption =[];
$nearbysearch = "";
$distance = "";
$zipCode = "";
$place = "";
$check = 0;
$zipp = "";
$baseUrl = "http://svcs.ebay.com/services/search/FindingService/v1?";
$operationName = "findItemsAdvanced";
$serviceVersion = "1.0.0";
$securityAppname = "MengjieR-homework-PRD-7a6d6c7c3-de7ecbd9";
$responseDataformat = "JSON";
$entriesPerpage = "20";
?>
<html lang="en">
<head>
    <title>Product Search</title>
    <style>
    .kane{
        border: 2px solid lightgrey;
        width: 600px;
        margin: 0 auto;
    }
    .kane2{
        border-top: 2px solid lightgrey;
        margin-left: 10px;
        margin-right: 10px;
    }
    .align{
        text-align: center;
    }
    #title{
        /*font-family: "Arial Black", sans-serif;*/
        font-style: italic;
    }
    .subtitle{
        /*font-family: "Arial Black", sans-serif;*/
        font-size: 15px;
    }
    .optionality{
        font-family: "Arial Black", sans-serif;
        font-size: 15px;
    }
    .check{
        margin-left: 25px;
    float：left；
    }
    .check2{
        margin-left: 60px;
    }
    .butt{
    margin:0 auto;
    }
    #distance{
    margin-left: 30px;
    width:50px;
    }
    #zip{
        margin-left: 335px;
    }
    #colorgrey1{
        color: darkgray;
    }
    #colorgrey2{
        color: darkgray;
    }
    </style>

    <?php
    $locationURL = file_get_contents("http://ip-api.com/json");
    $curLocation = json_decode($locationURL);
    $zipp = $curLocation->zip;
    $lat = $curLocation->lat;
    $lon = $curLocation->lon;

    if ((!empty($lat)) && (!empty($lon))){
        $readyLocation = 1;
    }
    //echo $readyLocation;
    //echo $lat;
    //echo $lon;
    //echo $zipp;

    ?>
    <script type="text/javascript">

        function agreea() {
            if (document.getElementById('enablenearby').checked) {
                document.getElementById('distance').disabled = false;
                document.getElementById('herebu').disabled = false;
                document.getElementById('zip').disabled = false;
                document.getElementById('colorgrey1').style.color = 'black';
                document.getElementById('colorgrey2').style.color = 'black';
            } else {
                document.getElementById('distance').disabled = 'disabled';
                document.getElementById('herebu').disabled = 'disabled';
                document.getElementById('zip').disabled = 'disabled';
                document.getElementById('zipcode').disabled = 'disabled';
                document.getElementById('zipcode').required = false;
                document.getElementById('colorgrey1').style.color = 'darkgray';
                document.getElementById('colorgrey2').style.color = 'darkgray';
            }
        }
        function resetform(){
            //document.getElementById("form").reset();
            document.getElementById("category").value = "default";
            document.getElementsByName("keyword")[0].value = "";
            document.getElementsByName("zipcode")[0].value = "zip code";
            var check = document.forms[0];
            for (i=0; i<check.elements.length; i++) {
                if (check[i].type == "checkbox") {
                    check[i].checked = false;
                }
            }
            document.getElementById('colorgrey1').style.color= 'darkgray';
            document.getElementById('colorgrey2').style.color= 'darkgray';
            document.getElementById("zip").checked=false;
            document.getElementById("herebu").checked=true;
            document.getElementById("zip").disabled=true;
            document.getElementById("herebu").disabled=true;
            document.getElementById("zipcode").disabled=true;
            document.getElementById("distance").disabled=true;
            document.getElementsByName("distance")[0].value = "10";
            document.getElementsByName("condition")[0].checked = "";
            document.getElementsByName("shipoption")[0].checked = "";
            document.getElementById('zipcode').required = false;


        }
        function agreeb(){
            if (document.getElementById('zip').checked){
                document.getElementById('zipcode').disabled = false;
                document.getElementById('zipcode').required = true;
            }else{
                document.getElementById('zipcode').disabled = true;
                document.getElementById('zipcode').required = false;
            }
            if (document.getElementById('herebu').checked){
                 document.getElementById('zipcode').disabled = true;
                 document.getElementById('zipcode').required = false;
            }
        }


    </script>
</head>
<body>
<?php
if (isset($_POST["submit"])){
    $keyword = $_POST['keyword'];
    $condition = $_POST['condition'];
    $category = $_POST['category'];
    $shippingOption = $_POST['shipoption'];
    $nearbysearch = $_POST['enablenearby'];
    $distance = $_POST['distance'];
    $zipCode = $_POST['zipcode'];
    $place = $_POST['place'];
//    echo "keyword".":";
//    echo $keyword."<br>";
//    echo "category".":";
//    echo $category."<br>";
//    echo "condition".":";
//    //echo $condit
//   foreach ($condition as $v){
//        echo $v."<br>";
//    }
//   //echo "shippingOption".":";
//   foreach ($shippingOption as $v){
//        echo $v."<br>";
//    }
//    echo "nearbysearch".":";
//    echo $nearbysearch."<br>";
//    echo "distance".":";
//    echo $distance."<br>";
//    echo "zipCode".":";
//    echo $zipCode."<br>";
//    echo "place".":";
//    echo $place."<br>";
    if ($distance==''){$distance=10;}
    //echo $distance;
    $freeshipOption = "false";
    $localshipOption = "false";
    foreach ($shippingOption as $v) {
        if ($v =='free'){
            $freeshipOption = "true";
        }
        if ($v =='local'){
            $localshipOption = "true";
        }
    }
    $itermFilter = array("MaxDistance"=>$distance, "FreeShippingOnly"=>$freeshipOption,
        "LocalPickupOnly"=>$localshipOption, "HideDuplicateItems"=>"true", "Condition"=>$condition);
    $queryUrl = $baseUrl."OPERATION-NAME=".$operationName."&SERVICE-VERSION=".$serviceVersion."&SECURITY-APPNAME=".
        $securityAppname."&RESPONSE-DATA-FORMAT=".$responseDataformat."&REST-PAYLOAD&paginationInput.entriesPerPage=".
        $entriesPerpage."&keywords=".$keyword."&buyerPostalCode=".$zipCode;
    //echo $queryUrl;
    $i = 0;
    foreach ($itermFilter as $name=>$value){
        if ($name=="Condition"){
            if ($value != ""){
                $queryUrl =$queryUrl."&itemFilter(".$i.").name=".$name;
                $j = 0;
                foreach ($condition as $v){
                    $queryUrl= $queryUrl."&itemFilter(".$i.").value(".$j.")=".$v;
                    $j++;
                }
            }
        }else {
            $queryUrl=$queryUrl."&itemFilter(".$i.").name=".$name;
            $queryUrl=$queryUrl."&itemFilter(".$i.").value=".$value;
        }
        $i++;
    }
    echo $queryUrl."<br>";
    $los = file_get_contents($queryUrl);
    $result = json_decode($los);
    $photo = array("");
    $name = array("");
    $price = array("");
    $zpp = array("");
    $con = array("");
    $ship = array("");
    $answer = $result->findItemsAdvancedResponse[0]->searchResult[0]->item;
    //echo count($answer);
//    for($i=0;$i<$entriesPerpage;$i++){
//        if ($answer[$i]->title[0]!="") {
//            array_push($name,$answer[$i]->title[0]);
//        }else{
//            array_push($name,"N/A");
//        }
//        if ($answer[$i]->sellingStatus[0]->currentPrice[0]!="") {
//            array_push($price,$answer[$i]->sellingStatus[0]->currentPrice[0]->__value__);
//        }else{
//            array_push($price,"N/A");
//        }
//
//    }
    foreach($answer as $ans){
        if ($ans->title[0]!="") {
            array_push($name,$ans->title[0]);
        }else{
            array_push($name,"N/A");
        }
        if ($ans->sellingStatus[0]->currentPrice[0]->__value__!="") {
            array_push($price,$ans->sellingStatus[0]->currentPrice[0]->__value__);
        }else{
            array_push($price,"N/A");
        }
        if ($ans->postalCode[0]!="") {
        array_push($zpp,$ans->postalCode[0]);
        }else{
            array_push($zpp,"N/A");
        }
        if ($ans->galleryURL[0]!="") {
            array_push($photo,$ans->galleryURL[0]);
        }else{
            array_push($photo,"N/A");
        }
        if ($ans->condition[0]->conditionDisplayName[0]!="") {
            array_push($con,$ans->condition[0]->conditionDisplayName[0]);
        }else{
            array_push($con,"N/A");
        }
        if ($ans->shippingInfo[0]->shippingServiceCost[0]->__value__!="") {
            if ($ans->shippingInfo[0]->shippingServiceCost[0]->__value__=="0.0"){
                array_push($ship,"Free Shipping");
            }else{
                array_push($ship,$ans->shippingInfo[0]->shippingServiceCost[0]->__value__);
            }
        }else{
            array_push($ship,"N/A");
        }
    }

    foreach ($name as $v){
        echo $v."<br>";
    }
    foreach ($con as $v){
        echo $v."<br>";
    }
    foreach ($ship as $v){
        echo $v."<br>";
    }

}
?>
<div class="kane">
    <div class="align">
        <h1 id="title">Product Search</h1>
    </div>
    <div class="kane2">
        <form id="form" name="form" action="" method="POST" onload="">
            <table>
                <tr>
                    <td class="subtitle">Keyword</td>
                    <td><input type="text" name="keyword" value="<?php if(isset($_POST["keyword"])) echo $_POST["keyword"];?>" class="keyword" required></td>
                </tr>
                <tr>
                    <td class="subtitle">Category</td>
                    <td><label>
                            <select name="category" id="category">
                                <option class="optionality" value="default">All Categories</option>
                                <option class="optionality" value="Art" <?php if (isset($_POST["category"])&&$_POST["category"]=="Art") echo "selected";?>>Art</option>
                                <option class="optionality" value="Baby" <?php if (isset($_POST["category"])&&$_POST["category"]=="Baby") echo "selected";?>>Baby</option>
                                <option class="optionality" value="Books" <?php if (isset($_POST["category"])&&$_POST["category"]=="Books") echo "selected";?>>Books</option>
                                <option class="optionality" value="Clothing" <?php if (isset($_POST["category"])&&$_POST["category"]=="Clothing") echo "selected";?>>Clothing</option>
                                <option class="optionality" value="Accessories" <?php if (isset($_POST["category"])&&$_POST["category"]=="Accessories") echo "selected";?>>Shoes & Accessories</option>
                                <option class="optionality" value="Computers/Tablets & Networking" <?php if (isset($_POST["category"])&&$_POST["category"]=="Computers/Tablets & Networking") echo "selected";?>>Computers/Tablets & Networking</option>
                                <option class="optionality" value="Health & Beauty" <?php if (isset($_POST["category"])&&$_POST["category"]=="Health & Beauty") echo "selected";?>>Health & Beauty</option>
                                <option class="optionality" value="Music" <?php if (isset($_POST["category"])&&$_POST["category"]=="Music") echo "selected";?>>Music</option>
                                <option class="optionality" value="Video Games & Consoles" <?php if (isset($_POST["category"])&&$_POST["category"]=="Video Games & Consoles") echo "selected";?>>Video Games & Consoles</option>
                            </select>
                        </label>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td class="subtitle">Condition</td>
                    <td>
                        <label><input type="checkbox" name="condition[]" value="New" class="check" <?php if(isset($_POST["condition"])){foreach ($_POST["condition"] as $v){if ($v=="New") echo "checked";}}?>>New</label>
                        <label><input type="checkbox" name="condition[]" value="Used" class="check" <?php if(isset($_POST["condition"])){foreach ($_POST["condition"] as $v){if ($v=="Used") echo "checked";}}?>>Used</label>
                        <label><input type="checkbox" name="condition[]" value="Unspecified" class="check" <?php if(isset($_POST["condition"])){foreach ($_POST["condition"] as $v){if ($v=="Unspecified") echo "checked";}}?>>Unspecified</label>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td class="subtitle">Shipping Option</td>
                    <td>
                        <label><input type="checkbox" name="shipoption[]" value="local" class="check2" <?php if(isset($_POST["shipoption"])){foreach ($_POST["shipoption"] as $v){if ($v=="local") echo "checked";}}?>>Local Pickup</label>
                        <label><input type="checkbox" name="shipoption[]" value="free" class="check2" <?php if(isset($_POST["shipoption"])){foreach ($_POST["shipoption"] as $v){if ($v=="free") echo "checked";}}?>>Free Shipping</label>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td><label><input type="checkbox" name="enablenearby" value="enablenearby" id="enablenearby" onclick="agreea()" <?php if(isset($_POST["enablenearby"])&&$_POST["enablenearby"]=="enablenearby") echo "checked";?>>Enable Nearby Search</label></td>
                    <td><label id="colorgrey1" style="font-weight: bold"><input type="text" name="distance" id="distance" value="<?php echo isset($_POST["distance"])?$_POST["distance"]:""?>" placeholder="10" disabled="">&nbsp;miles from</label></td>
                    <td><label id="colorgrey2"><input type="radio" name="place" value="here" id="herebu" disabled='disabled' <?php if(isset($_POST['place'])&&$_POST['place']=='here') echo "checked";?> onclick="agreeb()" checked>here</label></td>
                </tr>
            </table>
            <input type="radio" name="place" id="zip" value="zip" disabled="disabled" <?php if(isset($_POST['place'])&&$_POST['place']=='zip') echo "checked";?> onclick="agreeb()">
            <input type="text" name="zipcode" id="zipcode" placeholder="zip code" value="<?php echo isset($_POST["zipcode"])?$_POST["zipcode"]:""?>" disabled="" pattern="[0-9]{5}" title="Invalid zip code!">

            <table class="butt">
                <tr>
                    <td><button type="submit" name="submit" disabled="disabled" id="submit">Search</button></td>
                    <td><input type="button" name="clear" value="Clear" onclick="resetform()"></td>
                </tr>
            </table>
        </form>
        <br>
    </div>
</div>
<script type="text/javascript">
    if (<?php echo $readyLocation?> == 1){
        document.getElementById('submit').disabled = false;
    }
</script>
<script type="text/javascript">
    if (document.form.enablenearby.checked){
        document.getElementById('colorgrey1').style.color= 'black';
        document.getElementById('colorgrey2').style.color='black';
        document.getElementById('distance').disabled=false;
        document.getElementById('zip').disabled=false;
        document.getElementById('herebu').disabled=false;
        if (document.getElementById('zip').checked){
            document.getElementById('zip').checked=true;
            document.getElementById('zipcode').disabled=false;
        }
    }
</script>
</body>
</html>

