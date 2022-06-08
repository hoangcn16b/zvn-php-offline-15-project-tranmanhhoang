function changeStatus(url) {
    $.get(url, function(data) {
        // console.log(data);
        // <a id = "status-' . $id . '" href="javascript:changeStatus(\'' . $link . '\');" class="' . $status . ' rounded-circle btn-sm">
        //      <i class="fas fa-check"></i>
        // </a>
        var id = data[0];
        var status = data[1];
        var link = data[2];
        var classAdd = 'btn btn-success rounded-circle btn-sm';
        var element = 'a#status-' + id;
        if (status == 'inactive') {
            classAdd = 'btn btn-danger rounded-circle btn-sm';
        }
        $(element).attr('href', "javascript:changeStatus('" + link + "') ");
        $(element).attr('class', classAdd );
    }, 'JSON');
}

function changeGroupAcp(url) {
    $.get(url, function(data) {
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
        $(element).attr('class', classAdd );
    }, 'JSON');
}

$(document).ready(function(){
    $('input[name = "checkall"]').change(function() 
        {
            var checkStatus = this.checked;
                $('#mainOutput').find(':checkbox').each(function(){
                    this.checked = checkStatus;
                });
        });

        $('#form-input button[name = "submit-keyword"]').click(function() {
            $('#form-search').submit();
           
        });

        // $('#form-input a[name = clear-keyword]').click(function() {
        //     $('#form-input input[name = "input-keyword"]').val('');
        //     $('#form-search').submit();
        // })
});



