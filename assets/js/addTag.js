// assets/js/addTag.js

// loads the jquery package from node_modules
// var $ = require('jquery');

// import the function from greet.js (the .js extension is optional)
// ./ (or ../) means to look for a local file
// var greet = require('./greet');
//
// $(document).ready(function() {
//     $('body').prepend('<h1>'+greet('john')+'</h1>');
// });
function wrapText(elementID, openTag, closeTag) {

  var textArea = $('#' + elementID);
  var len = textArea.val().length;
  var start = textArea[0].selectionStart;
  var end = textArea[0].selectionEnd;
  var selectedText = textArea.val().substring(start, end);
  var replacement = openTag + selectedText + closeTag;
  // alert("replacement");
  textArea.val(textArea.val().substring(0, start) + replacement + textArea.val().substring(end, len));
}
$('#addTag').click(function() {
  // alert("Yeah!");
  wrapText("add_note_content", "<tag>", "</tag>");
});
// window.onload = function() {
//     if (window.jQuery) {
//         // jQuery is loaded
//         alert("Yeah!");
//     } else {
//         // jQuery is not loaded
//         alert("Doesn't Work");
//     }
// }
