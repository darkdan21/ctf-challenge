var steps=[];
var testindex = 0;
var loadInProgress = false;//This is set to true when a page is still loading

/*********SETTINGS*********************/
var webPage = require('webpage');
var page = webPage.create();
page.settings.userAgent = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36';
page.settings.javascriptEnabled = true;
phantom.cookiesEnabled = true;
phantom.javascriptEnabled = true;
/*********SETTINGS END*****************/

console.log('All settings loaded, start with execution');
page.onConsoleMessage = function(msg) {
    console.log(msg);
};
/**********DEFINE STEPS THAT FANTOM SHOULD DO***********************/
steps = [

    //Step 1 - Open Amazon home page
    function(){
        page.open("http://127.0.0.1/login.php", function(status){

        });
    },
    //Step 3 - Populate and submit the login form
    function(){
        page.evaluate(function(){
            document.getElementById("username").value="dan_j@live.co.uk";
            document.getElementById("password").value="1212";

            usernamechange();
            passwordchange();

        });
    },
    function(){
        page.evaluate(function(){
            document.getElementById("loginbutton").click();
        });
    },
    function(){ 
        page.open("http://127.0.0.1/unreadmessage.php", function(status){
        });
    },
    function(){
        page.evaluate(function(){
        });
    },
    function(){ 
        page.open("http://127.0.0.1/index.php", function(status){
        });
    },
    function(){
        page.evaluate(function(){
        });
    }


    ];
/**********END STEPS THAT FANTOM SHOULD DO***********************/

//Execute steps one by one
interval = setInterval(executeRequestsStepByStep,50);

function executeRequestsStepByStep(){
    if (loadInProgress == false && typeof steps[testindex] == "function") {
        //console.log("step " + (testindex + 1));
        steps[testindex]();
        testindex++;
    }
    if (typeof steps[testindex] != "function") {
        console.log("test complete!");
        phantom.exit();
    }
}

/**
 * These listeners are very important in order to phantom work properly. Using these listeners, we control loadInProgress marker which controls, weather a page is fully loaded.
 * Without this, we will get content of the page, even a page is not fully loaded.
 */
page.onLoadStarted = function() {
    loadInProgress = true;
    console.log('Loading started');
};
page.onLoadFinished = function() {
    loadInProgress = false;
    console.log('Loading finished');
};
page.onConsoleMessage = function(msg) {
    console.log(msg);
};
