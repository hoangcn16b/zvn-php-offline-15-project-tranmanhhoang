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

$(document).ready(function () {
    var controller = (getUrlVar('controller') == '') ? 'category' : getUrlVar('controller');
    var id = (getUrlVar('id') == '') ? 'empty' : getUrlVar('id');
    var action = (getUrlVar('action') == '') ? 'index' : getUrlVar('action');
    var classActive = controller;
    var checkClass = classActive + '-' + id + '-' + action;
    if (id == '' || id == 'empty') {
        checkClass = classActive + '-' + action;
    }
    console.log(checkClass);
    if ((classActive == 'category' || classActive == 'book' || id == 'empty') && checkClass != 'book-empty-list' && controller != 'index' && action != 'detail' && controller != 'user' && controller != 'cart') {
        $('.category-book').addClass('active');

    }
});

$(document).ready(function () {
    var controller = (getUrlVar('controller') == '') ? 'book' : getUrlVar('controller');
    var id = (getUrlVar('id') == '') ? 'empty' : getUrlVar('id');
    var classActive = controller + '-' + id;

    if (classActive == 'book-empty' && controller !== 'user') {
        $('.' + classActive).addClass('active');
    };
});

// function openModal(key, e) {
//     e.preventdefault();
//     console.log(key);
//     $('#' + key).modal('toggle');
// }

$(document).on('click', '#clickModal', function (e) {
    e.preventDefault();
    let classModal = $(this).attr('class');
    $('.myModal' + classModal).modal('show');
});
