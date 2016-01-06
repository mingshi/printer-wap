/**
 * @overview
 *
 * @author 
 * @version 2015/12/30
 */

function show_alert(msg)
{
    $('#msg').html(msg);
    $('#msg').fadeIn(1000);
    setTimeout(function() {$('#msg').fadeOut(1000);}, 2000);
}

function show_loading()
{
    $('.loading').show();
}

function hide_loading()
{
    $('.loading').hide();
}
