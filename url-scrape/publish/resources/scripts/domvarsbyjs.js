var url = 'http://www.bbc.com'

// // add json loader to config to fix errors
// var page = require('webpage');
var page = require('webpage').create();
console.log("\n\nCreating page:\n\n")
console.log('page:', page)

page.open(url, function(status) {
    console.log("\n\nOpening page:\n\n")

    // var title = page.evaluate(function() {
    //     return document.title;
    // });
    // console.log('Page title is ' + title);
    // phantom.exit();
});

// alert('test')

// var phantom=require('node-phantom');
// phantom.create(function(error,ph){
//     ph.createPage(function(err,page){
//         page.open(url ,function(err,status){
//             // do something
//             alert('opening')
//         });
//     });
// });

console.log('Page title is ' );

console.log('Hello, world!');
phantom.exit();