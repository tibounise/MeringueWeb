function render(url,outputFile) {
	var page = require('webpage').create();

    page.viewportSize = {
    	width:600,
    	height:600
    };
    page.paperSize = {
    	format: "A4",
    	orientation: "portrait",
    	margin: "1cm"
    };

    page.open(url, function(status) {
    	if (status !== "success") {
    		console.log("Something failed!");
    		phantom.exit();
    	} else {
    		page.evaluate(function() {
    			$('.uk-navbar-toggle').hide();
    		});

    		page.render(outputFile);

    		console.log(outputFile+" rendered !");

            phantom.exit();
    	}
    });
}

var fs 		 = require('fs'),
    system   = require('system');

render(system.args[1],system.args[2]);