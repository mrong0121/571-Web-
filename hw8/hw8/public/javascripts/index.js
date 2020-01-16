number = 50;
page = 1;
itemswish = new Array(50);
ittindex = "";

$('[data-toggle="tooltip"]').tooltip();



$(document).ready(function() {

    geoLocation();
    for (i=0;i<50;i++){
        itemswish[i]=0;
    }


    $("#searchitemsdiv").prop('hidden',true);
    $("#progress").prop('hidden',true);
    $("#paginationdiv").prop('hidden',true);
    $("#detaildiv").prop('hidden',true);

    $("input[name='location']").change(function () {
        if ($('#currentlocation').is(':checked')) {
            $("#ziperrorspan").prop("hidden",true);
            $("#zipcode").prop('disabled', true);
        } else if ($('#other').is(':checked')) {
            $("#ziperrorspan").prop("hidden",false);
            $("#zipcode").prop('disabled', false);
        }
    });

    $("#myForm").submit(function(event) {
        event.preventDefault();
        for (i=0;i<50;i++){
            itemswish[i]=0;
        }
        $("#detaildiv").prop('hidden',true);
        $("#progress").prop('hidden',false);
        $("#totaldiv").prop('hidden',false);
        var keyword = $("#keyword").val();
        var category = $("#category").val();
        var categoryId="";
        if (category=="All Categories"){
            categoryId="-1";
        }

        if (category == 'Art'){categoryId="550";}
        if (category == 'Baby'){categoryId="2984";}
        if (category == 'Books'){categoryId="267";}
        if (category == 'Clothing, Shoes & Accessories'){categoryId="11450";}
        if (category == 'Computers/Tablets & Networking'){categoryId="58058";}
        if (category == 'Health & Beauty'){categoryId="26395";}
        if (category == 'Music'){categoryId="11233";}
        if (category == 'Video Games & Consoles'){categoryId="1249";}

        if ($('#currentlocation').is(':checked')){
            var zipcode = curzip;
        }else{
            var zipcode = $("#zipcode").val();
        }
        if ($("#distance").val()==""){
            var distance = "10";
        }else{
            var distance = $("#distance").val();
        }

        var condition = [];
        if ($('#new').is(':checked')){
            condition.push($('#new').val());
        }
        if ($('#used').is(':checked')){
            condition.push($('#used').val());
        }
        if ($('#unspecified').is(':checked')){
            condition.push($('#unspecified').val());
        }
        if (condition==""){
            condition.push(-1);
        }

        var shipoption = [];
        if ($('#localpickup').is(':checked')){
            shipoption.push($('#localpickup').val());
        }
        if ($('#freeshipping').is(':checked')){
            shipoption.push($('#freeshipping').val());
        }

        if(shipoption==""){
            shipoption.push(-1);
        }

        var url =  "http://localhost:8081/"+"keyword/"+keyword+"/category/"+categoryId+"/condition/"+condition+"/shipoption/"+shipoption+"/distance/"+distance+"/zipcode/"+zipcode;
        //alert(url);
        console.log(url);
        $.get(url, function(data) {
            // $("#searchTable").html("");
            // // $("#progressBar").hide();
            // $("#searchTable").show();
            xxdata = data;
            console.log(data);
            createTable(data);

        });
    });

});




'use strict';
var app =angular.module('myApp', ['ngMaterial', 'ngMessages', 'material.svgAssetsCache', 'ui.bootstrap', 'angular-svg-round-progressbar']);
app.controller('DemoCtrl', DemoCtrl);
app.controller('PaginationDemoCtrl', function ($scope, $log) {
    $scope.totalItems = number;
    $scope.currentPage = 1;

    $scope.setPage = function (pageNo) {
        $scope.currentPage = pageNo;
    };

    $scope.pageChanged = function() {
        $log.log('Page changed to: ' + $scope.currentPage);
        $log.log(itemsinfo);
        $log.log(number);
        page = $scope.currentPage;
        makeTable(itemsinfo,$scope.currentPage,number);

    };

    $scope.maxSize = 5;
    $scope.bigTotalItems = 175;
    $scope.bigCurrentPage = 1;
});
app.controller("detailctrl",function($scope){
    $scope.canhavedetail = false;
    $scope.clicklist = function() {
        $scope.canhavedetail = true;
        $("#progress").prop("hidden",false);
        $("#detaildiv").prop("hidden",true);
        $("#formdiv").prop("hidden",true);
        $("#searchitemsdiv").prop("hidden",false);
        $("#formdiv").prop("hidden",false);
        $("#progress").prop("hidden",true);
        $scope.getWishlist();
    };
    $scope.clickfacebook = function(){
        // FB.init({appId: "2306384399603627", status: true, cookie: true});
        // FB.ui({
        //     method: 'share',
        //     display: 'popup',
        //     quote:"Buy "+shareitemarray[0].title+"at"+shareitemarray[1].price+" from LINK below.",
        //     href: shareitemarray[2].url,
        // }, function(response){});
        var shareUrl="https://www.facebook.com/dialog/share?app_id=2306384399603627&display=popup&href="+shareitemarray[2].url+
        "&redirect_uri="+shareitemarray[2].url+"&quote="+"Buy "+shareitemarray[0].title+"at"+shareitemarray[1].price+" from LINK below.";
        var win = window.open(shareUrl, '_blank','height=400,width=400');
        win.focus();

    };
    $scope.clicksimilar= function(){
        if (itsimilararray.length!=0){
            $scope.showtable=true;
            $scope.simitems = itsimilararray;
            for(i=0;i<itsimilararray.length;i++){
                $scope.simitems[i]['sprice'] = itsimilararray[i]['price'].toFixed(2);
                $scope.simitems[i]['sshippingcost'] = itsimilararray[i]['shippingcost'].toFixed(2);
            }
            if (itsimilararray.length>5){
                $scope.hasmore = true;
            }
            else{
                $scope.hasmore = false;
            }
        }else{
            $scope.showtable=false;
            $scope.hasmore = false;
        }
    };
    $scope.clickseller=function(){
        $scope.selleritems = {};
        for (i=0;i<sellerarray.length;i++){
            $scope.selleritems[Object.keys(sellerarray[i])] = sellerarray[i][Object.keys(sellerarray[i])];
        }
        //$scope.selleritems = sellerarray;
    };
    $scope.openStore = function(){
        var win = window.open($scope.selleritems.storeurl, '_blank');
        if(win){
            win.focus();
        }
    };

    //$scope.linkphotos = itemphotos;



    $scope.orderByattr = {name: 'Default', value: "default" };
    $scope.orderitems = [{name: 'Default', value: "default" },{ name: 'Product Name', value: "title" },{ name: 'Days Left', value: "timeleft" },{ name: 'Price', value: "price" },
        { name: 'Shipping Cost', value: "shippingcost" }];
    $scope.orderByad = {name:"Ascending",value:"+"};
    $scope.orderitems2 = [{name: 'Ascending', value: "+"},{ name: 'Descending', value: "-" }];
    $scope.limitnumber = 5;
    $scope.clickshowmore= function(){
        $scope.showmore = true;
        $scope.limitnumber = 20;
    };
    $scope.clickshowless= function(){
        $scope.showmore = false;
        $scope.limitnumber = 5;
    };

    $scope.clickdetail2 = function(){
        $("#progress").prop("hidden",false);
        $("#resulttab").trigger('click');
        $("#resulttab").tab('show');
        $("#searchitemsdiv").prop("hidden",true);
        $("#detaildiv").prop("hidden",false);
        $('#itdd').trigger('click');
        $('#itdd').tab('show');
        $("#progress").prop("hidden",true);
    };
    $scope.clickdetail=function(){
        $("#progress").prop("hidden",false);
        $("#searchitemsdiv").prop("hidden",true);
        $("#detaildiv").prop("hidden",false);
        $('#itdd').trigger('click');
        $('#itdd').tab('show');
        $("#progress").prop("hidden",true);
    };
    $scope.showwish = true;
    $scope.addtowish=function(){
        $scope.showwish = false;
        itemswish[ittindex] = 1;
    };
    $scope.removefromwish=function(){
        $scope.showwish = true;
        itemswish[ittindex] = 0;
    };

    $scope.getWishlist=function(){
        $scope.totalprice = 0;
        $scope.wishitems = new Array();
        var k = 1;
        for (i=0;i<number;i++){
            if(itemswish[i]==1) {
                var obj = {};
                var key = "number";
                obj[key] = k;
                // wishitem.push(obj);
                k = k + 1;
                var key = "id";
                obj[key] = items[i].itemId[0];
                var key = "index";
                obj[key] = i;
                // wishitem.push(obj);
                var key = "title";
                obj[key] = items[i].title[0];
                // wishitem.push(obj);
                if (items[i].title[0].length > 35) {
                    var titleshortened = items[i].title[0].slice(0, 35);
                    if (titleshortened.substr(titleshortened.length - 1) != " ") {
                        var dex = titleshortened.lastIndexOf(" ");
                        var titlefin = items[i].title[0].slice(0, dex);
                    } else {
                        var titlefin = titleshortened;
                    }
                } else {
                    var titlefin = items[i].title[0];
                }
                var key = "titlefin";
                obj[key] = titlefin;
                if (items[i].sellingStatus[0].currentPrice[0].__value__ != "") {
                    var key = "price";
                    obj[key] = items[i].sellingStatus[0].currentPrice[0].__value__;
                } else {
                    var key = "price";
                    obj[key] = "N/A";
                }
                $scope.totalprice = $scope.totalprice + parseFloat(items[i].sellingStatus[0].currentPrice[0].__value__);
                if (items[i].galleryURL[0] != "") {
                    var key = "image";
                    obj[key] = items[i].galleryURL[0];
                } else {
                    var key = "image";
                    obj[key] = "N/A";
                }
                if (items[i].shippingInfo[0].shippingServiceCost[0].__value__ != "") {
                    if (items[i].shippingInfo[0].shippingServiceCost[0].__value__ == "0.0") {
                        var key = "shipping";
                        obj[key] = "Free Shipping";
                    } else {
                        var money = "$" + items[i].shippingInfo[0].shippingServiceCost[0].__value__;
                        var key = "shipping";
                        obj[key] = money;
                    }
                } else {
                    var key = "shipping";
                    obj[key] = "N/A";
                }
                if (items[i].sellerInfo[0].sellerUserName[0] != "") {
                    var key = "seller";
                    obj[key] = items[i].sellerInfo[0].sellerUserName[0];
                } else {
                    var key = "seller";
                    obj[key] = "N/A";
                }
                var key = "icon";
                obj[key] = "remove_shopping_cart";
                $scope.wishitems.push(obj);
            }
            $scope.ttprice = ($scope.totalprice).toFixed(2);
        }
        console.log($scope.wishitems);
        if (itemswish[ittindex] == 0){
            $scope.showwish = true;
        }else{
            $scope.showwish = false;
        }
        if ($scope.wishitems.length>0){
            $scope.haswish = true;
        }else{
            $scope.haswish = false;
        }
    };

    $scope.qq=0;
    $scope.changewish= function (index, num) {
        if ($scope.qq == 1){
            $scope.wishitems[num-1].icon="remove_shopping_cart";
            itemswish[index] = 1;
            $scope.qq = 0;
        }else{
            $scope.wishitems[num-1].icon= "add_shopping_cart";
            itemswish[index] = 0;
            $scope.qq = 1;
        }
        $scope.getWishlist();
    };
    $scope.changecolor = function(iico){
        if(iico=="remove_shopping_cart"){
            return {"color":"#b1872f"};
        }else{
            return;
        }
    };

    $scope.clicktitle2 = function(index){
            $('#progress').prop("hidden",false);
            clickTitle(index);
            $('a[href="#resultdiv"]').click();
            $('#progress').prop("hidden",true);
    }
});


// autocomplete----------------------------------------------------------------------//
//-----------------------------------------------------------------------------------//
function DemoCtrl ($timeout, $q, $log) {
    var self = this;

    self.simulateQuery = false;
    // list of `zip` value/display objects
    self.zips = loadAll();
    self.querySearch = querySearch;
    self.selectedItemChange = selectedItemChange;
    self.searchTextChange = searchTextChange;

    function querySearch(query) {
        var results = query ? self.zips.filter(createFilterFor(query)) : self.zips,
            deferred;
        if (self.simulateQuery) {
            deferred = $q.defer();
            $timeout(function () {
                deferred.resolve(results);
            }, Math.random() * 1000, false);
            return deferred.promise;
        } else {
            return results;
        }
    }

    function searchTextChange(text) {
        $log.info('Text changed to ' + text);
    }

    function selectedItemChange(item) {
        $log.info('Item changed to ' + JSON.stringify(item));
    }

    function loadAll() {
        var allzips = '90001, 90002, 90003, 90004, 90005';
        return allzips.split(/, +/g).map(function (zip) {
            return {
                value: zip.toLowerCase(),
                display: zip
            };
        });
    }
    function createFilterFor(query) {
        var lowercaseQuery = query.toLowerCase();

        return function filterFn(zip) {
            return (zip.value.indexOf(lowercaseQuery) === 0);
        };

    }


}

function getAutozip(tt) {
    // alert(tt);
    var url = "http://localhost:8081/autozip/"+tt;
    $.get(url, function(data) {
        var autozips ="";
        console.log(data);
        for (var i=0;i<5;i++){
            autozips += data.postalCodes[i].postalCode;
            autozips += ", ";
        }
        return autozips;
    });
}
// autocomplete----------------------------------------------------------------------//
//-----------------------------------------------------------------------------------//


// ****************************Search*******************************************
//********************************************************************************
function createTable(data) {
    if (data.findItemsAdvancedResponse[0].searchResult[0].item) {
        number = data.findItemsAdvancedResponse[0].searchResult[0].item.length;


        console.log(number);
        console.log(itemswish);
        items = data.findItemsAdvancedResponse[0].searchResult[0].item;
        itemsinfo = [];
        for (i = 0; i < number; i++) {
            var iteminfo = {};
            var index = "index";
            iteminfo[index] = i;
            if (items[i].title) {
                var key = "title";
                iteminfo[key] = items[i].title[0];
            } else {
                var key = "title";
                iteminfo[key] = "N/A";
            }
            if (items[i].sellingStatus[0].currentPrice[0].__value__) {
                var key = "price";
                iteminfo[key] = items[i].sellingStatus[0].currentPrice[0].__value__;
            } else {
                var key = "price";
                iteminfo[key] = "N/A";
            }
            if (items[i].postalCode) {
                var key = "zipcode";
                iteminfo[key] = items[i].postalCode[0];
            } else {
                var key = "zipcode";
                iteminfo[key] = "N/A";
            }
            if (items[i].galleryURL) {
                var key = "photo";
                iteminfo[key] = items[i].galleryURL[0];
            } else {
                var key = "photo";
                iteminfo[key] = "N/A";
            }
            if (items[i].shippingInfo[0].shippingServiceCost[0].__value__ != "") {
                if (items[i].shippingInfo[0].shippingServiceCost[0].__value__ == "0.0") {
                    var key = "shipping";
                    iteminfo[key] = "Free Shipping";
                } else {
                    var money = "$" + items[i].shippingInfo[0].shippingServiceCost[0].__value__;
                    var key = "shipping";
                    iteminfo[key] = money;
                }
            } else {
                var key = "shipping";
                iteminfo[key] = "N/A";
            }
            if (items[i].sellerInfo[0].sellerUserName[0] != "") {
                var key = "seller";
                iteminfo[key] = items[i].sellerInfo[0].sellerUserName[0];
            } else {
                var key = "seller";
                iteminfo[key] = "N/A";
            }
            var key = "id";
            iteminfo[key] = items[i].itemId[0];
            itemsinfo.push(iteminfo);
        }
        console.log(itemsinfo);

        var curpage = 1;

        makeTable(itemsinfo, curpage, number);

    }else{
        var error="<div id='errordiv'>No Records</div>";
        $("#resulttable").html(error);
        $("#searchitemsdiv").prop('hidden', false);
        $("#detailbutdiv").prop("hidden",true);
        $("#progress").prop('hidden', true);
        $("#paginationdiv").prop("hidden",true);
    }
}
function highlight(ittindex){
    var table = document.getElementById('itemstable');
    for (var i=0;i < table.rows.length;i++){
        if (i == parseInt(ittindex+1)){
        table.rows[ittindex+1].style.backgroundColor = "#C7C8CA";}
        else{
            if (i%2==1){
                table.rows[i].style.backgroundColor = "#353A3F";
            }else{
                table.rows[i].style.backgroundColor = "#3F4449";
            }
        }
    }
}

function makeTable(itemsinfo,page,number){
    var table = "<table id='itemstable' class='table table-striped table-dark table-hover'><thead><th>#</th><th>Image</th><th>Title</th><th>Price</th><th>Shipping</th><th>Zip</th><th>Seller</th><th>Wishlist</th></thead>";
    table += "<tbody>";
    var k = page*10;
    if (number<k){
        k=number;
    }
    for (i = (page-1)*10; i < k; i++) {
        table += "<tr><td>" + (i + 1) + "</td>";
        table += "<td><img class='itemsimage' src='" + itemsinfo[i].photo + "' width='30%' </td>";
        if (itemsinfo[i].title.length > 35){
            var titleshortened = itemsinfo[i].title.slice(0,35);
            if(titleshortened.substr(titleshortened.length -1)!=" "){
                var dex = titleshortened.lastIndexOf(" ");
                var titlefin = itemsinfo[i].title.slice(0, dex);
            } else {
                var titlefin = titleshortened;
            }
        }else{
            var titlefin = itemsinfo[i].title;
        }
        table += "<td><a href='#' data-toggle='tooltip' data-placement='bottom' title=\""+itemsinfo[i].title+"\" onclick='clickTitle("+itemsinfo[i].id+")'>"+titlefin+"...</a></td>";
        table += "<td>" +"$"+ itemsinfo[i].price + "</td>";
        table += "<td>" + itemsinfo[i].shipping + "</td>";
        table += "<td>" + itemsinfo[i].zipcode + "</td>";
        table += "<td>" + itemsinfo[i].seller + "</td>";
        if (itemswish[i]==0){
            table += "<td><button  onclick='clickAddwish("+i+")'><i class=\"material-icons\">add_shopping_cart</i></button></td>";
        }else{
            table += "<td><button  onclick='clickRemovewish("+i+")'><i class=\"material-icons\" style='color: #b1872f'>remove_shopping_cart</i></button></td>";
        }

        table += "</tr>";
    }
    table += "</tbody></table>";
    $("#resulttable").html(table);
    $("#progress").prop('hidden', true);
    $("#searchitemsdiv").prop('hidden', false);


    if(number>0) {
        $("#paginationdiv").prop('hidden',false);
    }else{
        $("#paginationdiv").prop('hidden',true);
    }
}
function clickTitle(index){

    $("#progress").prop('hidden', true);
    $("#searchitemsdiv").prop("hidden",true);
    $('#itdd').trigger('click');
    $('#itdd').tab('show');
    createItemdetailtable(index);
    var title="";
    for (i=0;i<number;i++){
        if (itemsinfo[i].id == index){
            title=itemsinfo[i].title;
            ittindex = i;
        }
    }
    highlight(ittindex);
    createItemphototable(title);
    createItemshippingtable(index);
    createItemsimilartable(index);

}
// ****************************Search*******************************************
//********************************************************************************


// ****************************Detail*******************************************
//********************************************************************************
function createItemdetailtable(index){
    var url =  "http://localhost:8081/"+"itemspec/"+index;
    //alert(url);
    console.log(url);
    $.get(url, function(data) {
        console.log(data);
        itemDeatail = makeItemdetaildata(data);
        makeSharedata(data);
        createItemsellertable(data);
        console.log(itemDeatail);
        if (itemDeatail!=0){
           makeItemdetailtable(itemDeatail);
        }
    });
}
function makeSharedata(data){
    var itemres = data;
    var itemtitle = itemres.Item.Title;
    var itemid = itemres.Item.ItemId;
    var itemprice = "$"+itemres.Item.CurrentPrice.Value;
    var itemurl = itemres.Item.ViewItemURLForNaturalSearch;
    shareitemarray = new Array();
    pushArray("title",itemtitle,shareitemarray);
    pushArray("price",itemprice,shareitemarray);
    pushArray("url",itemurl,shareitemarray);
    console.log("afasfa");
    console.log(shareitemarray);
}

function makeItemdetaildata(data){
    if (data.Item){
        var itemres = data;
        var itemphoto = itemres.Item.PictureURL;
        var itemtitle = itemres.Item.Title;
        var itemsubtitle = itemres.Item.Subtitle;
        var itemlocation = itemres.Item.Location +", "+itemres.Item.PostalCode;
        //var itemprice = itemres.Item.CurrentPrice.Value+" "+itemres.Item.CurrentPrice.CurrencyID;
        var itemprice = "$"+itemres.Item.CurrentPrice.Value;
        var itemseller = itemres.Item.Seller.UserID;
        if(itemres.Item.ReturnPolicy.ReturnsWithin){
            var itemreturn = itemres.Item.ReturnPolicy.ReturnsAccepted+" within "+itemres.Item.ReturnPolicy.ReturnsWithin;
        }else{
            var itemreturn = itemres.Item.ReturnPolicy.ReturnsAccepted;
        }
        itemarray = new Array();
        //pushArray("Photo",itemphoto,itemarray);
        var itphobj = {};
        var itphkey = "Photo";
        itphobj[itphkey] = itemphoto;
        itemarray.push(itphobj);
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
        return itemarray;
    }else{
        var error="<div id='errordiv'>No Records</div>";
        $("#itemdetailtable").html(error);
        $("#itemdetailtable").prop("hidden",false);
        return 0;
    }
}
function makeItemdetailtable(data){
    var table = "<table id='itemDetailtable' class='table table-striped table-dark'>";
    table += "<tbody>";
    for (i=0;i<data.length;i++){
            if (Object.keys(data[i]) == "Photo"){
                imgarray = data[i][Object.keys(data[i])];
                openImgwin(imgarray);
                table +="<tr><td><b>Product Image<b></td><td ><a href='#' style='color: #6a8c9b;' data-toggle='modal' data-target='#myModal'>View Product Images Here</a></td></tr>";
                //table +="<tr><td><b>Product Image<b></td><td><a href='#' style='color: #6a8c9b;' ng-click='openmodal()' data-toggle='modal' data-target='#myModal'>View Product Images Here</a></td></tr>";
            }
            else{
                table += "<tr><td><b>"+Object.keys(data[i])+"<b></td><td>"+data[i][Object.keys(data[i])]+"</td></tr>";
            }
    }

    table+="</tbody></table>";
    var titletxt = "<h2>";
    for (i=0;i<data.length;i++){
        if (Object.keys(data[i]) == "Title"){
            titletxt+=data[i][Object.keys(data[i])];
        }
    }
    $("#progress").prop('hidden', true);
    $("#titlediv").html(titletxt);
    $("#itemdetailtable").html(table);
    $("#detaildiv").prop('hidden', false);


}
function pushArray(str, zhi, arr){
    var itobj = {};
    var itkey = str;
    if(zhi){
        itobj[itkey] = zhi;
        arr.push(itobj);
    }
}

function openImgwin(data){
    var imgtxt = "<div class=\"modal fade\" id=\"myModal\" role=\"dialog\">"+
        "<div class=\"modal-dialog\">"+
        "<div class=\"modal-content\">"+
        "<div class=\"modal-header\">"+
        "<h4 class=\"modal-title\">Product Images</h4>"+
        "<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>"+
        "</div>"+
        "<div id=\"carouselExampleControls\" class=\"carousel slide\" data-ride=\"carousel\" data-interval=\"false\" >"+
        "<div class=\"kongs\"></div>"+
        "<div class=\"carousel-inner\">"+
        // "<div>123{{linkphotos}}321</div>"+
        "<div class=\"carousel-item active\" >"+
        "<a href='#'><img style='border: 10px solid black' onclick=\"openPic(this)\" class=\"d-block w-100\"  src='"+data[0]+"' alt=\"123\"></a>"+
        "</div>";
        for (i=1;i<data.length;i++){
        imgtxt+="<div class=\"carousel-item\" >"+
        "<a href='#'><img onclick=\"openPic(this)\" style='border: 10px solid black' class=\"d-block w-100\" src='"+data[i]+"' alt=\"123\"></a>"+
        "</div>";}
        imgtxt+="</div>"+
        "<a class=\"carousel-control-prev\" href=\"#carouselExampleControls\" role=\"button\" data-slide=\"prev\">"+
        "<span style=\"background-color: black\" class=\"carousel-control-prev-icon\" aria-hidden=\"true\"></span>"+
        "<span class=\"sr-only\">Previous</span>"+
        "</a>"+
        "<a class=\"carousel-control-next\" href=\"#carouselExampleControls\" role=\"button\" data-slide=\"next\">"+
        "<span style=\"background-color: black\" class=\"carousel-control-next-icon\" aria-hidden=\"true\"></span>"+
        "<span class=\"sr-only\">Next</span>"+
        "</a>"+
        "</div>"+
        "<div class=\"kongs\"></div>"+
        "<div class=\"modal-footer\">"+
        "<button type=\"button\" style='background-color: #333641; color: white' class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>"+
        "</div>"+
        "</div>"+
        "</div>"+
        "</div>";

    $("#kkkkkk").html(imgtxt);
}
// ****************************Detail*******************************************
//********************************************************************************

// ****************************Photo*******************************************
//********************************************************************************
function createItemphototable(title){
    console.log(title);
    var url =  "http://localhost:8081/"+"phototitle/"+title;
    //alert(url);
    console.log(url);
    $.get(url, function(data) {
        var itemphotosdata = makeitphotodata(data);
        if (itemphotosdata){
        makeitphototable(itemphotosdata);
        $("#photokuang").prop("hidden",false);
        $("#itemphotoserror").prop("hidden",true);
        }else{
            $("#photokuang").prop("hidden",true);
            $("#itemphotoserror").prop("hidden",false);
        }
    });
}

function makeitphotodata(data){
    console.log(data);
    // var itdata = JSON.parse(data);
    itemphotos = new Array();
    if (data.items){
        for (i=0;i<8;i++){
             itemphotos.push(data.items[i].link);
        }
    }
    console.log(itemphotos);
    return itemphotos;

}
function makeitphototable(data){
    $("#pic1").attr("src",data[0]);
    $("#pic2").attr("src",data[1]);
    $("#pic3").attr("src",data[2]);
    $("#pic4").attr("src",data[3]);
    $("#pic5").attr("src",data[4]);
    $("#pic6").attr("src",data[5]);
    $("#pic7").attr("src",data[6]);
    $("#pic8").attr("src",data[7]);
    //id="photosdiv"
}
function openPic(imgs) {
    var win = window.open(imgs.src, '_blank');
    if (win) {
        //Browser has allowed it to be opened
        win.focus();
    } else {
        //Browser has blocked it
        alert('Please allow popups for this website');
    }
}
// ****************************Photo*******************************************
//********************************************************************************


// ****************************Shipping*******************************************
//********************************************************************************
function createItemshippingtable(index){
    var ittm = "";
    for (i=0;i<number;i++){
        if (items[i].itemId[0]==index){
            ittm = items[i];
        }
    }
    var itshippingarray = makeItemshippingdata(ittm);
    makeItemshippingtable(itshippingarray);
}
function makeItemshippingdata(data){
    var shippingarray = new Array();
    if (data.shippingInfo[0].shippingServiceCost[0].__value__){
        var obj ={};
        obj["shippingcost"] = data.shippingInfo[0].shippingServiceCost[0].__value__;
        shippingarray.push(obj);
    }
    if (data.shippingInfo[0].shipToLocations[0]){
        var obj ={};
        obj["shippinglocation"] = data.shippingInfo[0].shipToLocations[0];
        shippingarray.push(obj);
    }
    if (data.shippingInfo[0].handlingTime[0]){
        var obj ={};
        obj["shippinghandletime"] = data.shippingInfo[0].handlingTime[0];
        shippingarray.push(obj);
    }
    if (data.shippingInfo[0].expeditedShipping[0]){
        var obj ={};
        obj["shippingexpedited"] = data.shippingInfo[0].expeditedShipping[0];
        shippingarray.push(obj);
    }
    if (data.shippingInfo[0].oneDayShippingAvailable[0]){
        var obj ={};
        obj["shippingoneday"] = data.shippingInfo[0].oneDayShippingAvailable[0];
        shippingarray.push(obj);
    }
    if (data.returnsAccepted[0]){
        var obj ={};
        obj["shippingreturn"] = data.returnsAccepted[0];
        shippingarray.push(obj);
    }
    console.log(shippingarray);

    return shippingarray;
}
function makeItemshippingtable(data){
    var table = "<table id='itemDetailshippingtable' class='table table-striped table-dark'>";
    table += "<tbody>";
        for (i=0;i<data.length;i++) {
            if (Object.keys(data[i]) == "shippingcost") {
                if (data[i][Object.keys(data[i])] == "0.0") {
                    table += "<tr><td><b>Shipping Cost<b></td><td>Free Shipping</td></tr>";
                } else {
                    table += "<tr><td><b>Shipping Cost<b></td><td>" + "$" + data[i][Object.keys(data[i])] + "</td></tr>";
                }
            }
            if (Object.keys(data[i]) == "shippinglocation") {
                table += "<tr><td><b>Shipping Locations<b></td><td>" + data[i][Object.keys(data[i])] + "</td></tr>";
            }
            if (Object.keys(data[i]) == "shippinghandletime") {
                if (data[i][Object.keys(data[i])] == "0" || data[i][Object.keys(data[i])] == "1") {
                    table += "<tr><td><b>Handling Time<b></td><td>" + data[i][Object.keys(data[i])] + " day</td></tr>";
                } else {
                    table += "<tr><td><b>Handling Time<b></td><td>" + data[i][Object.keys(data[i])] + " days</td></tr>";
                }
            }
            if (Object.keys(data[i]) == "shippingexpedited") {
                if (data[i][Object.keys(data[i])] == "true") {
                    table += "<tr><td><b>Expedited Shipping<b></td><td>" + "<i class=\"material-icons\" style='color: green'>check</i>" + "</td></tr>";
                } else {
                    table += "<tr><td><b>Expedited Shipping<b></td><td>" + "<i class=\"material-icons\" style='color: red'>close</i>" + "</td></tr>";
                }
            }
            if (Object.keys(data[i]) == "shippingoneday") {
                if (data[i][Object.keys(data[i])] == "true") {
                    table += "<tr><td><b>One Day Shipping<b></td><td>" + "<i class=\"material-icons\" style='color: green'>check</i>" + "</td></tr>";
                } else {
                    table += "<tr><td><b>One Day Shipping<b></td><td>" + "<i class=\"material-icons\" style='color: red'>close</i>" + "</td></tr>";
                }
            }
            if (Object.keys(data[i]) == "shippingreturn") {
                if (data[i][Object.keys(data[i])] == "true") {
                    table += "<tr><td><b>Return Accepted<b></td><td>" + "<i class=\"material-icons\" style='color: green'>check</i>" + "</td></tr>";
                } else {
                    table += "<tr><td><b>Return Accepted<b></td><td>" + "<i class=\"material-icons\" style='color: red'>close</i>" + "</td></tr>";
                }
            }
        }
    table+="</tbody></table>";
    $('#shippingdiv').html(table);
}
// ****************************Shipping*******************************************
//********************************************************************************

//*****************************Seller**********************************************
//*********************************************************************************
function createItemsellertable(data){
    sellerarray = makeItemsellerdata(data);
    makeItemsellertable(sellerarray);
}
function makeItemsellerdata(data){
    console.log("asdfa");
    console.log(data);
    var sellerarray = new Array();
    if(data.Item.Seller.FeedbackScore){
        pushArray("feedbackscore",data.Item.Seller.FeedbackScore,sellerarray);}
    if(data.Item.Seller.PositiveFeedbackPercent){
        pushArray("positivefeedbackpercent",data.Item.Seller.PositiveFeedbackPercent,sellerarray);}
    if(data.Item.Seller.FeedbackRatingStar){
        pushArray("feedbackratingstar",data.Item.Seller.FeedbackRatingStar.replace("Shooting",''),sellerarray);}
    if(data.Item.Seller.TopRatedSeller){
        pushArray("topratedseller",data.Item.Seller.TopRatedSeller,sellerarray);}
    if (data.Item.Storefront){
        if(data.Item.Storefront.StoreName){
            pushArray("storename",data.Item.Storefront.StoreName,sellerarray);}
        if(data.Item.Storefront.StoreURL){
            pushArray("storeurl",data.Item.Storefront.StoreURL,sellerarray);}
    }
    console.log(sellerarray);
    return sellerarray;
}
function makeItemsellertable(data){

    var table = "<table id='itemDetailsellertable' class='table table-striped table-dark'>";
    table += "<tbody>";
    for (i=0;i<data.length;i++){
        var color = "";
        if (Object.keys(data[i]) == "feedbackratingstar"){
            color = data[i][Object.keys(data[i])].replace('Shooting','');
        }
        if (Object.keys(data[i]) == "feedbackscore"){
            table +="<tr><td><b>Feedback Score</b></td><td>"+data[i][Object.keys(data[i])]+"</td></tr>";
        }
        if (Object.keys(data[i]) == "positivefeedbackpercent"){
            table +="<tr><td><b>Popularity</b></td><td>"+"<round-progress max='100' current='20' color='#45ccce' bgcolor='#eaeaea' radius='10' stroke='3' semi='false' rounded='true' clockwise='true' responsive='false' duration='80' animation='easeInOutQuart' animation-delay='0'></round-progress>"+"</td></tr>";
        }
        if (Object.keys(data[i]) == "feedbackscore"){
            if (parseInt(data[i][Object.keys(data[i])])>=10000){
                table += "<tr><td><b>Feedback Rating Star</b></td><td>" + "<i class=\"material-icons\" style='color:"+color+" '>stars</i>" + "</td></tr>";
            }else{
                table += "<tr><td><b>Feedback Rating Star</b></td><td>" + "<i class=\"material-icons\" style='color:"+color+" '>star_border</i>" + "</td></tr>";
            }
        }
        if (Object.keys(data[i]) == "topratedseller"){
            if (data[i][Object.keys(data[i])]=="true"){
                table += "<tr><td><b>Top rated</b></td><td>" + "<i class=\"material-icons\" style='color: green'>check</i>" + "</td></tr>";
            }else{
                table += "<tr><td><b>Top rated</b></td><td>" + "<i class=\"material-icons\" style='color: red'>close</i>" + "</td></tr>";
            }
        }
        if (Object.keys(data[i]) == "storename"){
            table +="<tr><td><b>Store Name</b></td><td>"+data[i][Object.keys(data[i])]+"</td></tr>";
        }
        if (Object.keys(data[i]) == "storeurl"){
            table +="<tr><td><b>Buy Product At</b></td><td><a target='_blank' style='color: green' href='"+data[i][Object.keys(data[i])]+"'>Store</a></td></tr>";
        }

    }
    table+="</tbody></table>";
    //$('#sellerdiv').html(table);

}
//*****************************Seller**********************************************
//*********************************************************************************

//*****************************Similar**********************************************
//*********************************************************************************
function createItemsimilartable(index){

    var url =  "http://localhost:8081/"+"similarid/"+index;
    console.log(url);
    $.get(url, function(data) {
        makeItemsimilardata(data);
    });

}
function makeItemsimilardata(data){
    itsimilararray = new Array();
    if(data){
    console.log(data);
    for (i = 0; i < data.getSimilarItemsResponse.itemRecommendations.item.length; i++) {
        var iteminfo = {};
        var index = "index";
        iteminfo[index] = i;
        if (data.getSimilarItemsResponse.itemRecommendations.item[i].imageURL) {
            var key = "photo";
            iteminfo[key] = data.getSimilarItemsResponse.itemRecommendations.item[i].imageURL;
        } else {
            var key = "photo";
            iteminfo[key] = "N/A";
        }
        if (data.getSimilarItemsResponse.itemRecommendations.item[i].title) {
            var key = "title";
            iteminfo[key] = data.getSimilarItemsResponse.itemRecommendations.item[i].title;
        } else {
            var key = "title";
            iteminfo[key] = "N/A";
        }
        if (data.getSimilarItemsResponse.itemRecommendations.item[i].viewItemURL) {
            var key = "viewitemurl";
            iteminfo[key] = data.getSimilarItemsResponse.itemRecommendations.item[i].viewItemURL;
        } else {
            var key = "viewitemurl";
            iteminfo[key] = "N/A";
        }
        if (data.getSimilarItemsResponse.itemRecommendations.item[i].buyItNowPrice.__value__) {
            var key = "price";
            iteminfo[key] = parseFloat(data.getSimilarItemsResponse.itemRecommendations.item[i].buyItNowPrice.__value__);
        } else {
            var key = "price";
            iteminfo[key] = "N/A";
        }
        if (data.getSimilarItemsResponse.itemRecommendations.item[i].shippingCost.__value__) {
            var key = "shippingcost";
            iteminfo[key] = parseFloat(data.getSimilarItemsResponse.itemRecommendations.item[i].shippingCost.__value__);
        } else {
            var key = "shippingcost";
            iteminfo[key] = "N/A";
        }
        if (data.getSimilarItemsResponse.itemRecommendations.item[i].timeLeft) {
            var key = "timeleft";
            var ss= data.getSimilarItemsResponse.itemRecommendations.item[i].timeLeft;
            iteminfo[key] = parseInt(ss.substring(ss.indexOf('P')+1,ss.indexOf("D")));
        } else {
            var key = "timeleft";
            iteminfo[key] = "N/A";
        }
        var key = "id";
        iteminfo[key] = data.getSimilarItemsResponse.itemRecommendations.item[i].itemId;
        itsimilararray.push(iteminfo);
    }
    console.log(itsimilararray);
    makeItemsimilartable(itsimilararray);
    }
}
function  makeItemsimilartable(data){
    // alert("321");
    // alert(data.length);
}

//*****************************Similar**********************************************
//*********************************************************************************

function clickAddwish(index){
    itemswish[index]=1;
    makeTable(itemsinfo,page,number);
}
function clickRemovewish(index){
    itemswish[index]=0;
    makeTable(itemsinfo,page,number);
}
function geoLocation() {
    document.getElementById('submitbut').disabled = true;
    var url = "http://ip-api.com/json";
    if (window.XMLHttpRequest){var xmlhttp = new XMLHttpRequest();}
    else{if(window.ActiveXObject){
        try{
            var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }catch (e) {
        }
    }
    }
    xmlhttp.overrideMimeType("application/json");
    xmlhttp.open("GET", url, false);
    try {
        xmlhttp.send();
    } catch (e) {
        alert(e.message);
    }
    if (xmlhttp.status == 200 && xmlhttp.readyState == 4) {
        var jsonDoc = xmlhttp.responseText;
    } else {
        alert("Error");
    }
    try {
        var data = JSON.parse(jsonDoc);
    } catch (e) {
        alert(e.message);
    }
    curzip = data.zip;
}
function clickClear(){
    //document.getElementById("myForm").reset();
    for (i=0;i<50;i++){
        itemswish[i]=0;
    }
    //$("#keyword").val('');
    //$("#keyword").attr("required", true);
    $('#myForm').trigger("reset");
    $("#keyword").prop("required",true);
    $("#totaldiv").prop('hidden',true);

}
