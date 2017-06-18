FixTopPadding();
$(window).resize(function(){
  FixTopPadding();
});
function FixTopPadding(){
  $('body').css(
    'padding-top',
    $('#topNav').outerHeight()
  );
}
