// function changeStatus(url) {
//     $.get(url, function (data) {
//         // console.log(data);
//         // <a id = "status-' . $id . '" href="javascript:changeStatus(\'' . $link . '\');" class="' . $status . ' rounded-circle btn-sm">
//         //      <i class="fas fa-check"></i>
//         // </a>
//         var id = data[0];
//         var status = data[1];
//         var link = data[2];
//         var classAdd = 'btn btn-success rounded-circle btn-sm';
//         var element = 'a#status-' + id;
//         if (status == 'inactive') {
//             classAdd = 'btn btn-danger rounded-circle btn-sm';
//         }
//         $(element).attr('href', "javascript:changeStatus('" + link + "') ");
//         $(element).attr('class', classAdd);
//     }, 'JSON');
// }

function changeGroupAcp(url) {
    $.get(url, function (data) {
        console.log(data);
        var id = data[0];
        var groupAcp = data[1];
        var link = data[2];
        var classAdd = 'btn btn-success rounded-circle btn-sm';
        var element = 'a#groupAcp-' + id;
        if (groupAcp == 0) {
            classAdd = 'btn btn-danger rounded-circle btn-sm';
        }
        $(element).attr('href', "javascript:changeGroupAcp('" + link + "') ");
        $(element).attr('class', classAdd);
    }, 'JSON');
}

$(document).ready(function () {
    $('input[name = "checkall"]').change(function () {
        var checkStatus = this.checked;
        $('#mainOutput').find(':checkbox').each(function () {
            this.checked = checkStatus;
        });
    });

    $('#form-input button[name = "submit-keyword"]').click(function () {
        $('#form-search').submit();

    });
    // $('#form-input a[name = clear-keyword]').click(function() {
    //     $('#form-input input[name = "input-keyword"]').val('');
    //     $('#form-search').submit();
    // })

    $('.filter-element').on('change', function () {
        $('#form-search').submit();
    });

    // $('.ajax-status').click(function (e) {
    //     e.preventDefault();
    //     let url = $(this).attr('href');
    //     var parent = $(this).parent();
    //     console.log(parent);
    //     $.ajax({
    //         type: "GET",
    //         url: url,
    //         // data: "data",
    //         // dataType: "dataType",
    //         success: function (response) {
    //             parent.html(response);
    //         }
    //     });
    // });
    // $("#btn-bullk-action").notify("Hello Box", { className: 'success', position: 'top-center' });

    $(document).on('click', '.ajax-status', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        var parent = $(this).parent();
        $.ajax({
            type: "GET",
            url: url,
            // data: "data",
            // dataType: "dataType",
            success: function (response) {
                parent.html(response);
                parent.find('.ajax-status').notify("Success!", { className: 'success', position: 'top-center' });
            }
        });
    });

    $(document).on('click', '.ajax-group-acp', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        var parent = $(this).parent();
        $.ajax({
            type: "GET",
            url: url,
            // data: "data",
            // dataType: "dataType",
            success: function (response) {
                parent.html(response);
                parent.find('.ajax-group-acp').notify("Success!", { className: 'success', position: 'top-center' });
            }
        });
    });

    $('.select-group').on('change', function () {
        var value = $(this).val();
        var url = $(this).data('geturl');
        url = url.replace('value_new', value);
        var parent = $(this).parent();
        $.ajax({
            type: "GET",
            url: url,
            success: function (response) {
                parent.find('.select-group').notify("Success!", { className: 'success', position: 'top-center' });
            }
        });
    });

    $('.btn-acpt-delete').click(function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure?',
            // text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
                // Swal.fire(
                //     'Deleted!',
                //     'Your data has been deleted.',
                //     'success'
                // )
            }
        })
    });

    // document.getElementById('random-password').value = make_password(5);
    function make_password(length) {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() *
                charactersLength));
        }
        return result;
    }

});

function getUrlVar(key) {
    var result = new RegExp(key + "=([^&]*)", "i").exec(window.location.search);
    return result && unescape(result[1]) || "";
}
$(document).ready(function () {
    var controller = (getUrlVar('controller') == '') ? 'index' : getUrlVar('controller');
    // var action = (getUrlVar('action') == '') ? 'index' : getUrlVar('action');
    var action = 'index';
    var classActive = controller + '-' + action;
    $('.' + classActive).addClass('active');
});




