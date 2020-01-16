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
$enzip = "";
$ready = 0;
$categoryId = "";
$count = 0;
$baseUrl = "http://svcs.ebay.com/services/search/FindingService/v1?";
$operationName = "findItemsAdvanced";
$serviceVersion = "1.0.0";
$securityAppname = "MengjieR-homework-PRD-7a6d6c7c3-de7ecbd9";
$responseDataformat = "JSON";
$entriesPerpage = "20";
$callName = "GetSingleItem";
$responseencoding = "JSON";
$siteid = '0';
$version = '967';
$ItemId = "";
$IncludeSelector= 'Description,Details,ItemSpecifics';
$photo = array("");
$name = array("");
$price = array("");
$zpp = array("");
$con = array("");
$ship = array("");
$itid = array("");
?>
<html lang="en">
<head>
    <title>Product Search</title>
    <style>
    a:hover{
        color: #d8d7d7;
    }
    a{
        color: black;
        text-decoration:none;
    }
    .error{
        border: 2px solid lightgrey;
        text-align: center;
        background-color: #f5f5f5;
        width: 800px;
        margin: auto;
        margin-top: 25px;
    }
    .kane{
        border: 2px solid lightgrey;
        width: 600px;
        margin: 0 auto;
        background-color: whitesmoke;
    }
    #form{
        margin-top: 10px;
    }
    .kane2{
        border-top: 2px solid lightgrey;
        margin-top: -12px;
        margin-left: 10px;
        margin-right: 10px;
    }
    .align{
        text-align: center;
    }
    #title{
        margin-top: 0px;
        font-style: italic;
    }
    .subtitle{
        font-size: 15px;
    }
    .optionality{
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
        margin-left: 350px;
    }
    #colorgrey1{
        color: darkgray;
    }
    #colorgrey2{
        color: darkgray;
    }
    </style>
    <script type="text/javascript">
        function geoLocation() {
            document.getElementById('submit').disabled = true;
            url = "http://ip-api.com/json";
            xmlhttp = new XMLHttpRequest();
            xmlhttp.overrideMimeType("application/json");
            xmlhttp.open("GET", url, false);
            try {
                xmlhttp.send();
            } catch (e) {
                alert(e.message);
            }
            if (xmlhttp.status == 200 && xmlhttp.readyState == 4) {
                jsonDoc = xmlhttp.responseText;
            } else {
                alert("Error");
            }
            try {
                data = JSON.parse(jsonDoc);
            } catch (e) {
                alert(e.message);
            }
            cc = data.zip;
            if (data.zip != '') {
                document.getElementById('submit').disabled = false;
            }
            document.getElementById('herebu').value = cc;
        }
    </script>
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
<body onload="geoLocation()">
<div class="kane">
    <div class="align">
        <h1 id="title">Product Search</h1>
    </div>
    <div class="kane2">
        <form id="form" name="form" action="" method="POST" onload="">
            <table>
                <tr>
                    <td class="subtitle"><b>Keyword<b></td>
                    <td><input type="text" name="keyword" value="<?php if(isset($_POST["keyword"])) echo $_POST["keyword"];?>" class="keyword" required></td>
                </tr>
                <tr>
                    <td class="subtitle"><b>Category<b></td>
                    <td><label>
                            <select name="category" id="category">
                                <option class="optionality" value="default">All Categories</option>
                                <option class="optionality" value="Art" <?php if (isset($_POST["category"])&&$_POST["category"]=="Art") echo "selected";?>>Art</option>
                                <option class="optionality" value="Baby" <?php if (isset($_POST["category"])&&$_POST["category"]=="Baby") echo "selected";?>>Baby</option>
                                <option class="optionality" value="Books" <?php if (isset($_POST["category"])&&$_POST["category"]=="Books") echo "selected";?>>Books</option>
                                <option class="optionality" value="Clothing" <?php if (isset($_POST["category"])&&$_POST["category"]=="Clothing") echo "selected";?>>Clothing</option>
                                <option class="optionality" value="Shoes & Accessories" <?php if (isset($_POST["category"])&&$_POST["category"]=="Shoes & Accessories") echo "selected";?>>Shoes & Accessories</option>
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
                    <td class="subtitle"><b>Condition<b></td>
                    <td>
                        <label><input type="checkbox" name="condition[]" value="New" class="check" <?php if(isset($_POST["condition"])){foreach ($_POST["condition"] as $v){if ($v=="New") echo "checked";}}?>>New</label>
                        <label><input type="checkbox" name="condition[]" value="Used" class="check" <?php if(isset($_POST["condition"])){foreach ($_POST["condition"] as $v){if ($v=="Used") echo "checked";}}?>>Used</label>
                        <label><input type="checkbox" name="condition[]" value="Unspecified" class="check" <?php if(isset($_POST["condition"])){foreach ($_POST["condition"] as $v){if ($v=="Unspecified") echo "checked";}}?>>Unspecified</label>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td class="subtitle"><b>Shipping Option<b></td>
                    <td>
                        <label><input type="checkbox" name="shipoption[]" value="local" class="check2" <?php if(isset($_POST["shipoption"])){foreach ($_POST["shipoption"] as $v){if ($v=="local") echo "checked";}}?>>Local Pickup</label>
                        <label><input type="checkbox" name="shipoption[]" value="free" class="check2" <?php if(isset($_POST["shipoption"])){foreach ($_POST["shipoption"] as $v){if ($v=="free") echo "checked";}}?>>Free Shipping</label>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td><label><input type="checkbox" name="enablenearby" value="enablenearby" id="enablenearby" onclick="agreea()" <?php if(isset($_POST["enablenearby"])&&$_POST["enablenearby"]=="enablenearby") echo "checked";?>><b>Enable Nearby Search<b></label></td>
                    <td><label id="colorgrey1" style="font-weight: bold"><input type="text" name="distance" id="distance" value="<?php echo isset($_POST["distance"])?$_POST["distance"]:""?>" placeholder="10" disabled="">&nbsp;miles from</label></td>
                    <td><label id="colorgrey2"><input type="radio" name="place" value="here" id="herebu" disabled='disabled' <?php if(isset($_POST['place'])&&$_POST['place']=='here') echo "checked";?> onclick="agreeb()" checked>Here</label></td>
                </tr>
            </table>
            <input type="radio" name="place" id="zip" value="zip" disabled="disabled" <?php if(isset($_POST['place'])&&$_POST['place']=='zip') echo "checked";?> onclick="agreeb()">
            <input type="text" name="zipcode" id="zipcode" placeholder="zip code" value="<?php echo isset($_POST["zipcode"])?$_POST["zipcode"]:""?>" disabled="" title="Invalid zip code!">

            <table class="butt">
                <tr>
                    <td><button type="submit" name="submit" id="submit">Search</button></td>
                    <td><input type="button" name="clear" value="Clear" onclick="resetform()"></td>
                </tr>
            </table>
            <input type="hidden" id="extra" name="extra" value="Content of the extra variable" >
        </form>
        <br>
    </div>
</div>
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

    function checkZip($ss){
        if (strlen($ss) == 5 && is_numeric($ss)){
            return true;
        }
        return false;
    }
    function checkDistance($ss){
        if (is_numeric($ss) && $ss>=0){
            return true;
        }
        return false;
    }

    if ($distance==''){$distance=10;}
    $ready = 1;
    if ($zipCode!=''&&checkZip($zipCode)!=true){
        echo "<div class=\"error\">Zipcode is invalid</div>";
        $ready = 2;
    }
    if (checkDistance($distance)!=true){
        echo "<div class=\"error\">Distance is invalid</div>";
        $ready = 2;
    }
    //echo $ready;
    if ($category!='default'){
        if ($category == 'Art'){$categoryId="550";}
        if ($category == 'Baby'){$categoryId="2984";}
        if ($category == 'Books'){$categoryId="267";}
        if ($category == 'Clothing'){$categoryId="11450";}
        if ($category == 'Shoes & Accessories'){$categoryId="11450";}
        if ($category == 'Computers/Tablets & Networking'){$categoryId="58058";}
        if ($category == 'Health & Beauty'){$categoryId="26395";}
        if ($category == 'Music'){$categoryId="11233";}
        if ($category == 'Video Games & Consoles'){$categoryId="1249";}
    }

    if ($place=='zip'){
        $enzip = $zipCode;
    }else {
        $enzip = $place;
    }
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
    if ($nearbysearch == "enablenearby" ){
        $itermFilter = array("MaxDistance"=>$distance, "FreeShippingOnly"=>$freeshipOption,
            "LocalPickupOnly"=>$localshipOption, "HideDuplicateItems"=>"true", "Condition"=>$condition);
        $queryUrl = $baseUrl."OPERATION-NAME=".$operationName."&SERVICE-VERSION=".$serviceVersion."&SECURITY-APPNAME=".
            $securityAppname."&RESPONSE-DATA-FORMAT=".$responseDataformat."&REST-PAYLOAD&paginationInput.entriesPerPage=".
            $entriesPerpage."&keywords=".$keyword."&buyerPostalCode=".$enzip;
    } else {
        $itermFilter = array("FreeShippingOnly"=>$freeshipOption,
            "LocalPickupOnly"=>$localshipOption, "HideDuplicateItems"=>"true", "Condition"=>$condition);
        $queryUrl = $baseUrl."OPERATION-NAME=".$operationName."&SERVICE-VERSION=".$serviceVersion."&SECURITY-APPNAME=".
            $securityAppname."&RESPONSE-DATA-FORMAT=".$responseDataformat."&REST-PAYLOAD&paginationInput.entriesPerPage=".
            $entriesPerpage."&keywords=".$keyword;
    }
    if ($categoryId!=''){
        $queryUrl = $queryUrl."&categoryId=".$categoryId;
    }
    $i = 0;
    foreach ($itermFilter as $key=>$value){
        if ($key=="Condition"){
            if ($value != ""){
                $queryUrl =$queryUrl."&itemFilter(".$i.").name=".$key;
                $j = 0;
                foreach ($condition as $v){
                    $queryUrl= $queryUrl."&itemFilter(".$i.").value(".$j.")=".$v;
                    $j++;
                }
            }
        }else {
            $queryUrl=$queryUrl."&itemFilter(".$i.").name=".$key;
            $queryUrl=$queryUrl."&itemFilter(".$i.").value=".$value;
        }
        $i++;
    }

    function getApi($qurl){
        $los = file_get_contents($qurl);
        $res = json_decode($los);
        return $res;
    }

    $result = getApi($queryUrl);
    $answer = $result->findItemsAdvancedResponse[0]->searchResult[0]->item;

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
                $money = "$".$ans->shippingInfo[0]->shippingServiceCost[0]->__value__;
                array_push($ship,$money);
            }
        }else{
            array_push($ship,"N/A");
        }
        array_push($itid, $ans->itemId[0]);
    }
    $count = count($name) - 1;
//    foreach ($itid as $v){
//        echo $v."<br>";
//    }
//    echo($count);
    if ($ready!=2 && $count==0){
        echo "<div class=\"error\"><b>No Seller Message found<b></div>";
        $ready = 2;
    }

}
?>


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
<script type="text/javascript">
    nameNum = "";
    ready = <?php echo $ready;?>;
    if (ready == '1'){
        //alert("ss");
        count = <?php echo $count;?>;
        photo = <?php echo json_encode($photo);?>;
        title = <?php echo json_encode($name);?>;
        price = <?php echo json_encode($price);?>;
        zpp = <?php echo json_encode($zpp);?>;
        con = <?php echo json_encode($con);?>;
        ship = <?php echo json_encode($ship);?>;
        itemId = <?php echo json_encode($itid);?>;
        createTable();
    }
    securityAppname = "MengjieR-homework-PRD-7a6d6c7c3-de7ecbd9";
    function clickName(b){
        var elem = document.getElementById('showtable');
        elem.parentNode.removeChild(elem);
        nameNum = b;
        var itemString = "http://open.api.ebay.com/shopping?callname=GetSingleItem&responseencoding=JSON&appid="+securityAppname+
            "&siteid=0&version=967&ItemID="+itemId[b]+"&IncludeSelector=Description,Details,ItemSpecifics";
        alert(itemString);

    }
    function createTable(){
        div = document.createElement('div');
        div.setAttribute("id", "tablediv");
        document.body.appendChild(div);
        table = document.createElement("table");
        table.setAttribute("id", "showtable");
        document.getElementById("tablediv").appendChild(table);
        var css = document.createElement("style");
        css.type = "text/css";
        css.innerHTML = "#tablediv{margin:auto;width:1200px;margin-top:20px;}";
        css.innerHTML += "#showtable{margin:auto; border-collapse: collapse;}";
        css.innerHTML += "#showtable th{ border:2px solid lightgrey;}";
        css.innerHTML += "#showtable td{ border:2px solid lightgrey;}";
        document.body.appendChild(css);
        var tabletxt = "<table"+
            ">" +
            '<tr>' +
            '<th>Index</th>' +
            '<th>Photo</th> ' +
            '<th>Name</th>' +
            '<th>Price</th>' +
            '<th>Zip code</th>' +
            '<th>Condition</th>' +
            '<th>Shipping Option</th>' +
            '</tr>';
        document.getElementById("showtable").innerHTML = tabletxt;
        var tt = document.getElementById("showtable");
        for (i=1;i<=count;i++) {
            var row = tt.insertRow(i);
            var x = row.insertCell(-1);
            x.innerHTML = '' + i;
            var x = row.insertCell(-1);
            x.innerHTML = "<img src='" + photo[i] + "'width='" + "50px" + "' alt='1'>";
            var x = row.insertCell(-1);
            x.innerHTML ="<a href='#' onclick='clickName("+i+")'>"+title[i]+"</a>";
            var x = row.insertCell(-1);
            x.innerHTML = '' + price[i];
            var x = row.insertCell(-1);
            x.innerHTML = '' + zpp[i];
            var x = row.insertCell(-1);
            x.innerHTML = '' + con[i];
            var x = row.insertCell(-1);
            x.innerHTML = '' + ship[i];
        }
    }
</script>
</body>
</html>

