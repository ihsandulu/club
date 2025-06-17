function tampilrow(a, id, colspan, tha, tda) {
    $('.xtr').remove();
    if ($(a).children().hasClass("fa-plus")) {
        $(".tampilrow").children().removeClass("fa-minus").addClass("fa-plus");
        $(a).children().removeClass("fa-plus").addClass("fa-minus");
        let th = '';
        let td = '';
        for (i = 0; i < tha.length; i++) {
            th = th + '<th>' + tha[i];
        }
        for (i = 0; i < tda.length; i++) {
            td = td + '<td>' + tda[i];
        }
        let tr = '<tr id="x' + id + '" class="xtr"><td colspan="' + colspan + '"><table id="dataTable" class="table table-condensed "><thead class=""><tr style="background-color:blanchedalmond;">' + th + '</tr></thead><tbody><tr style="background-color:white;">' + td + '</tr></tbody></table></td></tr>';

        $('#' + id).after(tr);

    } else {

        $(a).children().removeClass("fa-minus").addClass("fa-plus");
    }
}