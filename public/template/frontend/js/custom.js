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
});