
const date = new Date();
let year = date.getFullYear();
document.getElementById("year").innerHTML = year;



$(document).ready(function(){
    var unitTemp = 1;
    $(".unitChangeTemp").click(function() {
        if(unitTemp==1){
            unitTemp=2;
        }
        else{
            unitTemp=1;
        }
        $("#temper").load("../unitChange.php", {
            newUnit: unitTemp,
            condition: 1
        });
    });
});

$(document).ready(function(){
    var unitFeels = 1;
    $(".unitChangeFeel").click(function() {
        if(unitFeels==1){
            unitFeels=2;
        }
        else{
            unitFeels=1;
        }
        $("#feels").load("../unitChange.php", {
            newUnit: unitFeels,
            condition: 2
        });
    });
});

$(document).ready(function(){
    var unitPressure = 1;
    $(".unitChangePressure").click(function() {
        if(unitPressure==1){
            unitPressure=2;
        }
        else{
            unitPressure=1;
        }
        $("#pressure").load("../unitChange.php", {
            newUnit: unitPressure,
            condition: 3
        });
    });
});

$(document).ready(function(){
    var unitSnowfall = 1;
    $(".unitChangeSnowfall").click(function() {
        if(unitSnowfall==1){
            unitSnowfall=2;
        }
        else{
            unitSnowfall=1;
        }
        $("#snowfall").load("../unitChange.php", {
            newUnit: unitSnowfall,
            condition: 4
        });
    });
});

$(document).ready(function(){
    var unitBoiling = 1;
    $(".unitChangeBoiling").click(function() {
        if(unitBoiling==1){
            unitBoiling=2;
        }
        else{
            unitBoiling=1;
        }
        $("#boiling").load("../unitChange.php", {
            newUnit: unitBoiling,
            condition: 5
        });
    });
});

$(document).ready(function(){
    var unitWind = 1;
    $(".unitChangeWind").click(function() {
        if(unitWind==1){
            unitWind=2;
        }
        else if(unitWind==2){
            unitWind=3;
        }
        else if(unitWind==3){
            unitWind=4;
        }
        else{
            unitWind=1;
        }
        $("#wind").load("../unitChange.php", {
            newUnit: unitWind,
            condition: 6
        });
    });
});






/*
var unitTemp = 1;
var possibleUnitTemp = 2;

changeUnit(".unitChangeTemp","#temper",unitTemp,possibleUnitTemp);
//changeUnit(".unitChange","#temper",unitTemp,possibleUnitTemp)



function changeUnit(whichButton,toChange, currentUnit, possibleUnits){
    $(document).ready(function(){
        
        $(whichButton).click(function() {
            if(possibleUnits==2){
                if(currentUnit==1){
                    currentUnit=2;
                }
                else{
                    currentUnit=1;
                }
            }
            else if(possibleUnits==3){
                if(currentUnit==1){
                    currentUnit=2;
                }
                else if(currentUnit==2){
                    currentUnit=3;
                }
                else{
                    currentUnit=1;
                }
            }
            $(toChange).load("../temperatureUnit.php", {
                newUnit: currentUnit
            });
        });
    });
}
*/