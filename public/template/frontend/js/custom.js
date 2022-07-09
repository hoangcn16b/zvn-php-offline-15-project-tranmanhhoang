function getUrlVar(key) {
    var result = new RegExp(key + "=([^&]*)", "i").exec(window.location.search);
    return result && unescape(result[1]) || "";
}

$(document).ready(function () {
    var controller = (getUrlVar('controller') == '') ? '' : getUrlVar('controller');
    var action = (getUrlVar('action') == '') ? '' : getUrlVar('action');
    var classActive = controller + '-' + action;
    $('.' + classActive).addClass('active');
});

// $(document).ready(function () {
//     var controller = (getUrlVar('controller') == '') ? 'category' : getUrlVar('controller');
//     var id = (getUrlVar('id') == '') ? 'empty' : getUrlVar('id');
//     var action = (getUrlVar('action') == '') ? 'index' : getUrlVar('action');
//     var classActive = controller;
//     var checkClass = classActive + '-' + id + '-' + action;
//     if (id == '' || id == 'empty') {
//         checkClass = classActive + '-' + action;
//     }
//     if ((classActive == 'category' || classActive == 'book' || id == 'empty') && checkClass != 'book-empty-list' && controller != 'index' && action != 'detail' && controller != 'user' && controller != 'cart') {
//         $('.category-book').addClass('active');
//     }
// });

// $(document).ready(function () {
//     var controller = (getUrlVar('controller') == '') ? 'book' : getUrlVar('controller');
//     var id = (getUrlVar('id') == '') ? 'empty' : getUrlVar('id');
//     var classActive = controller + '-' + id;

//     if (classActive == 'book-empty' && controller !== 'user') {
//         $('.' + classActive).addClass('active');
//     };
// });

// function openModal(key, e) {
//     e.preventdefault();
//     console.log(key);
//     $('#' + key).modal('toggle');
// }

// $(document).on('click', '#clickModal', function (e) {
//     e.preventDefault();
//     let classModal = $(this).attr('class');
//     $('.myModal' + classModal).modal('show');
// });


$(document).ready(function () {

    function number_format(number, decimals, dec_point, thousands_sep) {
        // Strip all characters but numerical ones.
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    $(document).on('click', '.form-cart', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        var quantityNumber = $('.quantity-number').val();
        if (!quantityNumber) {
            quantityNumber = 1;
        }
        // var quantityNumber = document.getElementById('quantity-number').value;
        var parent = $('.quantity-cart').parent();
        var parentCart = $(this).parent();
        url = url + '&this_quantity=' + quantityNumber;
        $.ajax({
            type: "GET",
            url: url,
            success: function (response) {
                document.getElementById('quantity-cart').innerHTML = response;
                parent.find('.quantity-cart').notify("Success!", { className: 'success', position: 'bottom-center' });
                parentCart.find('.form-cart').notify("Success!", { className: 'success', position: 'right-center' });
            }
        });
    });


    $(document).on('change', '.input-number', function (e) {
        e.preventDefault();

        var url = $('.count').data('url-total');
        var parentQty = $('.quantity-cart').parent();
        var parentCart = $(this).parent();
        var qty = $(this).val();
        var price = $(this).data('price');
        var totalPerProd = qty * price;
        thisId = $(this).attr('id');

        url = url + '&book_id=' + thisId + '&this_quantity=' + qty + '&price=' + price;
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'JSON',
            success: function (response) {
                totalPerProd = number_format(totalPerProd, 0, ",", ".") + ' đ';
                document.getElementById('total-per-prod' + thisId).innerHTML = totalPerProd;
                var count = number_format(response[1], 0, ",", ".") + ' đ';
                document.getElementById('count-total').innerHTML = count;
                document.getElementById('quantity-cart').innerHTML = response[0];
                parentQty.find('.quantity-cart').notify("Success!", { className: 'success', position: 'bottom-center' });
                parentCart.find('.input-number').notify("Success!", { className: 'success', position: 'right-center' });
            }
        });
    });

});

