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
$itemresult = "";
$itemready = 0;
$index = "";
$baseUrl = "http://svcs.ebay.com/services/search/FindingService/v1?";
$operationName = "findItemsAdvanced";
$serviceVersion = "1.0.0";
$securityAppname = "MengjieR-homework-PRD-7a6d6c7c3-de7ecbd9";
$responseDataformat = "JSON";
$entriesPerpage = "20";
$ItemId = "";
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
    body{
        text-align: center;
    }
    #kuang{
        margin-top: 5px;
        margin-bottom: 5px;
        margin-left: 5px;
        margin-right: 5px;
        border:1px solid lightgrey;
    }
    #similarerror{
        border: 2px solid lightgrey;
        text-align: center;
        width: 800px;
        margin: auto;
        margin-top: 5px;
    }
    #sellererror{
        text-align: center;
        background-color: #f5f5f5;
        width: 800px;
        margin: auto;
        margin-top: 5px;
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
    #myform{
        margin-top: 10px;
    }
    .kane2{
        border-top: 2px solid lightgrey;
        margin-top: -12px;
        margin-left: 10px;
        margin-right: 10px;
        text-align: left;
    }
    .align{
        text-align: center;
    }
    #title{
        margin-top: 0px;
        font-weight: normal;
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
            document.getElementById('submitbut').disabled = true;
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
                document.getElementById('submitbut').disabled = false;
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
                document.getElementById('zipcode').required= true;
                document.getElementById('colorgrey1').style.color = 'black';
                document.getElementById('colorgrey2').style.color = 'black';
            } else {
                document.getElementById('distance').disabled = 'disabled';
                document.getElementById("herebu").checked=true;
                document.getElementById('distance').value = "";
                document.getElementById('distance').placehorder = '10';
                document.getElementById('herebu').disabled = 'disabled';
                document.getElementById('zip').disabled = 'disabled';
                document.getElementById('zipcode').disabled = 'disabled';
                document.getElementById('zipcode').value = 'zip code';
                document.getElementById('zipcode').required = false;
                document.getElementById('colorgrey1').style.color = 'darkgray';
                document.getElementById('colorgrey2').style.color = 'darkgray';
            }
        }
        function resetForm(){
            document.getElementById("category").value = "default";
            document.getElementsByName("keyword")[0].value = "";
            document.getElementsByName("zipcode")[0].value = "";
            document.getElementsByName("zipcode")[0].placeholder = "zip code";
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
            document.getElementsByName("distance")[0].value = "";
            document.getElementsByName("distance")[0].placeholder = "10";
            document.getElementById('zipcode').required = false;
            document.getElementById('hiddendiv').hidden = true;
            ernodes = document.getElementsByClassName('error');
            for (i=0;i<ernodes.length;i++){
                ernodes[i].hidden = true;
            }
            //document.getElementsByName("condition")[0].checked = "";
            //document.getElementsByName("shipoption")[0].checked = "";

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
                 document.getElementById('zipcode').value = "";
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
        <form id="myform" name="myform" action="" method="POST" onload="">
            <table>
                <tr>

                    <td colspan="2" font-size="15px"><b>Keyword<b><input type="text" name="keyword" value="<?php if(isset($_POST["keyword"])) echo $_POST["keyword"];?>" class="keyword" required></td>
                </tr>
                <tr>
                    <td class="subtitle"><b>Category<b></td>
                    <td><label>
                            <select name="category" id="category">
                                <option class="optionality" value="default">All Categories</option>
                                <option class="optionality" value="Art" <?php if (isset($_POST["category"])&&$_POST["category"]=="Art") echo "selected";?>>Art</option>
                                <option class="optionality" value="Baby" <?php if (isset($_POST["category"])&&$_POST["category"]=="Baby") echo "selected";?>>Baby</option>
                                <option class="optionality" value="Books" <?php if (isset($_POST["category"])&&$_POST["category"]=="Books") echo "selected";?>>Books</option>
                                <option class="optionality" value="Clothing, Shoes & Accessories" <?php if (isset($_POST["category"])&&$_POST["category"]=="Clothing, Shoes & Accessories") echo "selected";?>>Clothing, Shoes & Accessories</option>
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
            <input type="text" name="zipcode" id="zipcode" placeholder="zip code" required value="<?php echo isset($_POST["zipcode"])?$_POST["zipcode"]:""?>" disabled="">

            <table class="butt">
                <tr>
                    <td><button type="submit" name="submitbut" id="submitbut">Search</button></td>
                    <td><input type="button" name="clear" value="Clear" onclick="resetForm()"></td>
                </tr>
            </table>
        </form>
        <br>
    </div>
</div>
<div id="hiddendiv"></div>



<?php
if (isset($_POST["submitbut"])){
    $keyword = $_POST['keyword'];
    $keystr = urlencode($keyword);
    $keyword = $keystr;
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
        if ($category == 'Clothing, Shoes & Accessories'){$categoryId="11450";}
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
    if(is_array($shippingOption)){
    foreach ($shippingOption as $v) {
        if ($v =='free'){
            $freeshipOption = "true";
        }
        if ($v =='local'){
            $localshipOption = "true";
        }
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

    if(is_array($answer)){
    foreach($answer as $ans){
        if ($ans->title[0]!="") {
            array_push($name,$ans->title[0]);
        }else{
            array_push($name,"N/A");
        }
        if ($ans->sellingStatus[0]->currentPrice[0]->__value__!="") {
            array_push($price,"$".$ans->sellingStatus[0]->currentPrice[0]->__value__);
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
    }}
    $count = count($name) - 1;

    if ($ready!=2 && $count==0){
        echo "<div class=\"error\">No Records has been found</div>";
        $ready = 2;
    }

}

?>
<?php
    if (isset($_POST['getIndex'])){
        $index =  $_POST['getIndex'];
        $itemString = "http://open.api.ebay.com/shopping?callname=GetSingleItem&responseencoding=JSON&appid=".$securityAppname.
           "&siteid=0&version=967&ItemID=".$index."&IncludeSelector=Description,Details,ItemSpecifics";
        $loo = file_get_contents($itemString);
        $itemres = json_decode($loo);


        $itt = $itemres->Item->ItemID;
        $simString ="http://svcs.ebay.com/MerchandisingService?OPERATION-NAME=getSimilarItems&SERVICE-NAME=MerchandisingService&SERVICE-VERSION=1.1.0&CONSUMER-ID="
            .$securityAppname."&RESPONSE-DATA-FORMAT=JSON&REST-PAYLOAD&itemId=".$itt."&maxResults=8";
        $loa = file_get_contents($simString);
        $simres = json_decode($loa);

        $ready = 5;

    }
?>

<script type="text/javascript">
    if (document.myform.enablenearby.checked){
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
    arrowup = "http://csci571.com/hw/hw6/images/arrow_up.png";
    arrowdown = "http://csci571.com/hw/hw6/images/arrow_down.png";
    nameNum = "";
    securityAppname = "MengjieR-homework-PRD-7a6d6c7c3-de7ecbd9";
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
        createTable(itemId);
    }
    function pushArray(str, zhi, arr){
        var itobj = {};
        var itkey = str;
        if(zhi){
            itobj[itkey] = zhi;
            arr.push(itobj);
        }
    }

    if (ready == '5'){
        itemres=<?php echo json_encode($itemres)?>;
        if (itemres.Item){
            var itemphoto = itemres.Item.PictureURL[0];
            var itemtitle = itemres.Item.Title;
            var itemsubtitle = itemres.Item.Subtitle;
            var itemlocation = itemres.Item.Location +", "+itemres.Item.PostalCode;
            var itemprice = itemres.Item.CurrentPrice.Value+" "+itemres.Item.CurrentPrice.CurrencyID;
            var itemseller = itemres.Item.Seller.UserID;
            if (itemres.Item.ReturnPolicy.ReturnsWithin){
                var itemreturn = itemres.Item.ReturnPolicy.ReturnsAccepted+" within "+itemres.Item.ReturnPolicy.ReturnsWithin;
            }else {
                var itemreturn = itemres.Item.ReturnPolicy.ReturnsAccepted;
            }
            itemarray = new Array();
            pushArray("Photo",itemphoto,itemarray);
            pushArray("Title",itemtitle,itemarray);
            pushArray("Subtitle",itemsubtitle,itemarray);
            pushArray("Price",itemprice,itemarray);
            pushArray("Location",itemlocation,itemarray);
            pushArray("Seller",itemseller,itemarray);
            pushArray("Return Policy(US)",itemreturn,itemarray);
            if (itemres.Item.ItemSpecifics) {
                var itemspec = itemres.Item.ItemSpecifics.NameValueList;
                var itemspecnum = itemspec.length;
                for (i = 0; i < itemspecnum; i++) {
                    var itobj = {};
                    var itkey = itemspec[i].Name;
                    itobj[itkey] = itemspec[i].Value[0];
                    itemarray.push(itobj);
                }
            }
            // }else{
            //     var itobj = {};
            //     var itkey = "no";
            //     itobj[itkey] = "";
            //     itemarray.push(itobj);
            // }
        //console.log(itemarray);
            createItemtable();
        }else{
            var erdiv =document.createElement("div");
            erdiv.setAttribute("class","error");
            erdiv.innerText="This item does not exist any more!";
            //document.body.appendChild(erdiv);
            document.getElementById('hiddendiv').appendChild(erdiv);
        }
    }
    function createItemtable (){

        itemdiv = document.createElement('div');
        itemdiv.setAttribute("id", "itemtablediv");
        //document.body.appendChild(itemdiv);
        document.getElementById('hiddendiv').appendChild(itemdiv);
        itemtable = document.createElement("table");
        itemtable.setAttribute("id", "itemtable");
        document.getElementById("itemtablediv").appendChild(itemtable);
        var css = document.createElement("style");
        css.type = "text/css";
        css.innerHTML = "#itemtablediv{margin:auto;width:700px;margin-top:20px;}";
        css.innerHTML += "#itemtable{margin:auto; border-collapse: collapse;}";
        css.innerHTML += "#itemtable th{ text-align:left}";
        css.innerHTML += "#itemtable td{ border:2px solid lightgrey;text-align:left;}";
        document.body.appendChild(css);
        var tabletxt = "<table>";
        tabletxt +="<tr><th colspan=\"2\"><font size = '30px'><b>Item Details<b></th></tr>";
        for (i=0;i<itemarray.length;i++){
            if (Object.keys(itemarray[i]) == "Photo"){
                tabletxt +="<tr><td style='padding-left:10px;'><b>"+Object.keys(itemarray[i])+"<b></td><td style='padding-left:10px;'>"+"<img src='"+itemarray[i][Object.keys(itemarray[i])]+"' height='260px' alt=' '>"+"</td></tr>";
            }
            // else if (Object.keys(itemarray[i]) == "no"){
            //     tabletxt += "<tr><td style=width=30% ><b>No Detail Info from Seller"+"<b></td><td bgcolor='#d3d3d3'></td></tr>";
            // }
            else{
                tabletxt += "<tr><td style='padding-left:10px;'><b>"+Object.keys(itemarray[i])+"<b></td><td style='padding-left:10px;'>"+itemarray[i][Object.keys(itemarray[i])]+"</td></tr>";
            }
        }
        tabletxt+="</table>";
        document.getElementById("itemtable").innerHTML = tabletxt;
        putArrow();
    }
    function putArrow(){
        var css = document.createElement("style");
        css.type = "text/css";
        css.innerHTML = "#arrowupimage{margin:0 auto;width:25px;height:10px}";
        css.innerHTML += "#arrowdownimage{margin:0 auto; width:25px; height:10px;}";
        css.innerHTML += "#arrowdiv{margin:auto; text-align:center;}";
        css.innerHTML += "#arrowtable{margin:auto; text-align:center;}";
        document.body.appendChild(css);
        arrowdiv = document.createElement('div');
        arrowdiv.setAttribute("id", "arrowdiv");
        arrowdiv.style.marginTop="10px";
        //document.body.appendChild(arrowdiv);
        document.getElementById('hiddendiv').appendChild(arrowdiv);
        arrowupdiv = document.createElement('div');
        arrowupdiv.innerHTML="<div id='arrowupdiv'><font color='#808080'>click to show seller message</font></div>";
        arrowupimage = document.createElement('img');
        arrowupimage.id = 'arrowupimage';
        arrowupimage.src = arrowdown;
        arrowdiv.appendChild(arrowupdiv);
        arrowdiv.appendChild(arrowupimage);
        sellerdiv =document.createElement('div');
        sellerdiv.style.marginTop="10px";
        sellerdiv.id="sellerdiv";
        sellerdiv.style.margin = "auto";
        sellerdiv.style.width="80%";
        arrowdiv.appendChild(sellerdiv);

        arrowdowndiv = document.createElement('div');
        arrowdowndiv.innerHTML="<div id='arrowdowndiv'><font color='#808080'>click to show similar items</font></div>";
        arrowdiv.appendChild(arrowdowndiv);
        arrowdownimage = document.createElement('img');
        arrowdownimage.id = 'arrowdownimage';
        arrowdownimage.src = arrowdown;
        arrowdiv.appendChild(arrowdownimage);
        similardiv = document.createElement('div');
        similardiv.id="similardiv";
        similardiv.style.marginTop="10px";
        arrowdiv.appendChild(similardiv);
        simtable = document.createElement('table');
        simtable.id = "simtable";
        simtable.hidden = false;
        similardiv.appendChild(simtable);
        document.getElementById('arrowupimage').addEventListener("click",showSeller);
        document.getElementById('arrowdownimage').addEventListener("click",showSimilar);
    }
    function showSeller(){
        if (document.getElementById('arrowupimage').src==arrowdown){
            document.getElementById('similardiv').hidden = "hidden";
            document.getElementById('arrowdownimage').setAttribute("src",arrowdown);
            document.getElementById('arrowdowndiv').innerHTML="<font color='#808080'>click to show similar message";

            document.getElementById('sellerdiv').innerHTML="<iframe id ='fframe' scrolling='no' width='100%' frameborder='0'></iframe>";
            if (itemres.Item.Description){
                seller = itemres.Item.Description;
                document.getElementById('fframe').hidden = false;
                document.getElementById('fframe').srcdoc = seller;
                document.getElementById('fframe').onload = function(){
                    if (document.getElementById('fframe')){
                        //var fwidth = document.getElementById('fframe').contentWindow.document.body.scrollWidth+10+'px';
                        var fheight = document.getElementById('fframe').contentWindow.document.documentElement.scrollHeight+10+'px';
                       // document.getElementById('fframe').style.width = fwidth;
                        document.getElementById('fframe').style.height = fheight;
                    }};

                document.getElementById('arrowupimage').setAttribute("src",arrowup);
                document.getElementById('arrowupdiv').innerHTML="<font color='#808080'>click to hide seller message";
                document.getElementById('sellerdiv').hidden=false;
            }else{
                document.getElementById('sellerdiv').innerHTML="<div id='sellererror'><b>No Seller Message found<b></div>";
                document.getElementById('arrowupimage').setAttribute("src",arrowup);
                document.getElementById('arrowupdiv').innerHTML="<font color='#808080'>click to hide seller message";
                document.getElementById('sellerdiv').hidden=false;
            }
        } else{
                document.getElementById('sellerdiv').hidden ="hidden";
                document.getElementById('arrowupimage').setAttribute("src",arrowdown);
                document.getElementById('arrowupdiv').innerHTML="<font color='#808080'>click to show seller message";
        }
    }

    function showSimilar() {
        if (document.getElementById('arrowdownimage').src == arrowdown) {
            document.getElementById('sellerdiv').hidden = "hidden";
            document.getElementById('arrowupimage').setAttribute("src", arrowdown);
            document.getElementById('arrowupdiv').innerHTML = "<font color='#808080'>click to show seller message";
            simres = <?php echo json_encode($simres)?>;
            if (simres.getSimilarItemsResponse.itemRecommendations.item[0]) {
                simItems = simres.getSimilarItemsResponse.itemRecommendations.item;
                makeSimtabble(simItems);
                document.getElementById('arrowdownimage').setAttribute("src", arrowup);
                document.getElementById('arrowdowndiv').innerHTML = "<font color='#808080'>click to hide similar message";
                document.getElementById('similardiv').hidden=false;
            } else {
                document.getElementById('similardiv').innerHTML = "<div id='similarerror'><div id='kuang'><b>No Similar Item found<b></div></div>";
                document.getElementById('arrowdownimage').setAttribute("src", arrowup);
                document.getElementById('arrowdowndiv').innerHTML = "<font color='#808080'>click to hide similar message";
                document.getElementById('similardiv').hidden=false;
            }
        } else {
            document.getElementById('similardiv').hidden = "hidden";
            document.getElementById('arrowdownimage').setAttribute("src", arrowdown);
            document.getElementById('arrowdowndiv').innerHTML = "<font color='#808080'>click to show similar message";
        }
    }


    function makeSimtabble(simItems){
        simtable.hidden=false;
        var css = document.createElement("style");
        css.type = "text/css";
        css.innerHTML = "#similardiv{margin:auto; width:800px; margin-top:10px;}";
        css.innerHTML += "#simtable{display: block; overflow:auto;border:2px solid lightgrey;}";
        document.body.appendChild(css);
        var simtabletxt ="";
        simtabletxt+="<tr>";
        for (j=0;j<simItems.length;j++){simtabletxt += "<td><div style='width: 230px; padding-top: 20px;'><img src='" +simItems[j].imageURL + "'height='" + "150px" + "' alt=' '></div></td>";}
        simtabletxt+="</tr><tr>";
        for (j=0;j<simItems.length;j++){simtabletxt +="<td><a href='#' onclick='clicksimName("+simItems[j].itemId+")'>"+simItems[j].title+"</a></td>";}
        simtabletxt+="</tr><tr>";
        for (j=0;j<simItems.length;j++){simtabletxt += "<td><b>$"+simItems[j].buyItNowPrice.__value__+"<b></td>";}
        simtabletxt+="</tr><tr>";
        simtable.innerHTML = simtabletxt;
    }

    function clicksimName(bd){
        var element=document.getElementById('similardiv');
        element.parentNode.removeChild(element);
        document.getElementById('arrowdownimage').setAttribute("src",arrowdown);
        document.getElementById('arrowdowndiv').innerHTML="<font color='#d3d3d3'>click to show seller message";
        clickName(bd);
    }

    function clickName(b){
        console.log(b);
        if (document.getElementById('showtable')){
            var elem = document.getElementById('showtable');
            elem.parentNode.removeChild(elem);
        }
        input = document.createElement("input");
        input.type= "hidden";
        input.name= "getIndex";
        input.id="getIndex";
        input.value = b;
        document.getElementById('myform').appendChild(input);
        myform.submit();
    }

    function createTable(id){
        div = document.createElement('div');
        div.setAttribute("id", "tablediv");
        //document.body.appendChild(div);
        document.getElementById('hiddendiv').appendChild(div);
        table = document.createElement("table");
        table.setAttribute("id", "showtable");
        document.getElementById("tablediv").appendChild(table);
        var css = document.createElement("style");
        css.type = "text/css";
        css.innerHTML = "#tablediv{margin:auto;width:1200px;margin-top:20px;}";
        css.innerHTML += "#showtable{margin:auto; border-collapse: collapse;}";
        css.innerHTML += "#showtable th{ border:2px solid lightgrey;text-align:center}";
        css.innerHTML += "#showtable td{ border:2px solid lightgrey;text-align:left}";
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
            x.innerHTML = "<img src='" + photo[i] + "'width='" + "60px" + "' alt=' '>";
            var x = row.insertCell(-1);
            x.innerHTML ="<a href='#' onclick='clickName("+id[i]+")'>"+title[i]+"</a>";
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

