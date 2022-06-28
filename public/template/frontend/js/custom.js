function getUrlVar(key) {
    var result = new RegExp(key + "=([^&]*)", "i").exec(window.location.search);
    return result && unescape(result[1]) || "";
}

$(document).ready(function () {
    var controller = (getUrlVar('controller') == '') ? 'index' : getUrlVar('controller');
    var action = (getUrlVar('action') == '') ? 'index' : getUrlVar('action');
    var classActive = controller + '-' + action;
    console.log(classActive);
    $('.' + classActive).addClass('active');
    // document.getElementById('random-active-code').value = make_password(5);
    // function make_password(length) {
    //     var result = '';
    //     var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    //     var charactersLength = characters.length;
    //     for (var i = 0; i < length; i++) {
    //         result += characters.charAt(Math.floor(Math.random() *
    //             charactersLength));
    //     }
    //     return result;
    // }
});

$(document).ready(function () {
    var controller = (getUrlVar('controller') == '') ? 'category' : getUrlVar('controller');
    // var action = (getUrlVar('action') == '') ? 'index' : getUrlVar('action');
    var classActive = controller;
    if (classActive == 'category' || classActive == 'book') {
        console.log(classActive);
        $('.category-book').addClass('active');
    }

});
