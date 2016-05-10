var page = require('webpage').create(),
	system = require('system'),
	t, address;

if (system.args.length < 3) {
  console.log('Usage: load.js <some URL> filename');
  phantom.exit();
}

t       = Date.now();
address = system.args[1];
file    = system.args[2];

page.viewportSize = { width: 1280, height:960 };
page.settings.userAgent = 'Mozilla/5.0 (Windows NT 5.1; rv:8.0) Gecko/20100101 Firefox/7.0';

page.open(address, function(status) {
    if(status !== 'success'){
		console.log('FAIL to load: ' + address);
	}else{
		t = Date.now() - t;
        page.clipRect = { top: 0, left: 0, width: 1280, height:960 };
		console.log('Loading time ' + t + ' msec');
		page.render(file + '.png');
	}
	phantom.exit();
});
