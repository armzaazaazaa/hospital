var countchkfile = 1;
var objEmp;

$(document).ready(function() {

    $('#saveShow').hide();


    $('#btnAddFile').click(function() {



        var thtml = '<tr>';
        thtml += '<td width="16%">'
        thtml += '<select name="paytypededuct[]" class="form-control" onchange="changPaytype(this)">'
        thtml += '<option value="">รูปแบบการจ่าย</option>'
        thtml += '<option value="1">ประจำทุกเดือน</option>'
        thtml += '<option value="2">เฉพาะเดือน</option>'
        thtml += '</select>'
        thtml += '</td>';
        thtml += '<td width="16%"><select name="id_deduct[]" id="id_deduct' + countchkfile + '" class="form-control" ></select></td>';
        thtml += '<td width="16%"><input type="text" name="paydate[]" id="paydate' + countchkfile + '" ></td>';
        thtml += '<td width="16%"><input type="text" name="usedate[]" id="usedate' + countchkfile + '"></td>';
        thtml += '<td width="16%"><input type="text" name="enddate[]" id="enddate' + countchkfile + '"></td>';
        thtml += '<td width="10%"><input type="text" name="amount[]" class="form-control" size="3" ';
        thtml += " data-inputmask=\"'alias': 'decimal'\" class=\"form-control hidetext\" placeholder=\"0.00\" data-mask></div></td>";
        thtml += '<td width="19%"><input type="text" name="detail[]" class="form-control" size="7"></td>';
        thtml += '<td><button class="btn btn-sm btn-danger" type="button" id="btnRemoveFile"> ลบแถว </button></td>';
        thtml += '</tr>';



        $("#tblticket").last().append(thtml);
        $("[data-mask]").inputmask();


        $('#paydate' + countchkfile).datepicker({
            autoclose: true,
            language: 'th',
            dateFormat: 'yy-mm',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
        });


        $('#usedate' + countchkfile).datepicker({
            autoclose: true,
            language: 'th',
            dateFormat: 'yy-mm',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
        });

        $('#enddate' + countchkfile).datepicker({
            autoclose: true,
            language: 'th',
            dateFormat: 'yy-mm',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
        });

        var projects = objEmp;

        $('#saveShow').show();
        bindRemoveFile();
        bindHideteax(countchkfile)
        bindLoadsesucttem(countchkfile);
        countchkfile++;
    });

});

function bindHideteax(counting) {
    $("#paydate" + counting).hide();
    $("#usedate" + counting).hide();
    $("#enddate" + counting).hide();
}

function bindLoadsesucttem(counting) {
    $.ajax({
        method: "GET",
        url: "getlistdeducttem",
        success: function(data, textStatus, jQxhr) {
            console.log(data);
            var listdata = '<option selected="selected" value=""> รายการ </option>';
            $.each(data, function(key, value) {
                listdata += "<option value='" + data[key].ADD_DEDUCT_TEMPLATE_ID + "'>" + data[key].ADD_DEDUCT_TEMPLATE_NAME + "</option>";
            });
            $('#id_deduct' + counting).html(listdata);
        },
        error: function(jqXhr, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });
}

function bindRemoveFile() {
    $('button[id^="btnRemoveFile"]').filter(function() {
        $(this).click(function() {
            // var totalrow = $('#tbactionlist tr').length;
            var rowindex = $(this).closest('tr').index();
            // console.log(rowindex);
            if (rowindex >= 0) {
                //var start_tr = rowindex-4;
                removeTRFile(rowindex);
            }
        });
    });
}

function removeTRFile(index) {
    $('#tblticket tr').eq(index + 0).remove();
    countchkfile--;
}

function getCompanyForDepartment(val) {

    var _options1 = '<option selected="selected" value="">  เลือกแผนก  </option>';
    var _options2 = '<option selected="selected" value="">  เลือกฝ่าย  </option>';
    var _url = $('#urlGetDepartment').attr('title');
    var valueCompany = val.value;
    //$('#hiddenvalCompany').val(valueCompany);
    if(valueCompany !='') {
        $.ajax({
            method: "GET",
            url: _url + "?id_company=" + valueCompany,
            success: function (data, textStatus, jQxhr) {
                $.each(data, function (key, value) {
                    _options1 += "<option value='" + data[key].id + "'>" + data[key].name + "</option>";
                });
                $('#selectdepartment').html(_options1);
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    else {
        $('#selectdepartment').html(_options1);
        $('#selectsection').html(_options2);
    }
}

function getDepartmentForSection(val) {

    var _options = '<option selected="selected" value="">  เลือกฝ่าย  </option>';
    var _url = $('#urlGetSection').attr('title');
    var valueDepartment = val.value;
    //$('#hiddenvalDepartment').val(valueDepartment);

    if(valueDepartment !='') {
        $.ajax({
            method: "GET",
            url: _url + "?id_department=" + valueDepartment,
            success: function (data, textStatus, jQxhr) {
                $.each(data, function (key, value) {
                    _options += "<option value='" + data[key].id + "'>" + data[key].name + "</option>";
                });
                $('#selectsection').html(_options);
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    else {
        $('#selectsection').html(_options);
    }
}

function getDataEmpbyidcard(id_card) {

    $.ajax({
        method: "GET",
        url: "getdataempjson?id_card=" + id_card,
        success: function(data, textStatus, jQxhr) {
            //console.log(data);
            $('#BeShow').html(data['0'].Be);
            $('#NameShow').html(data['0'].Name);
            $('#Surname').html(data['0'].Surname);
            $('#Position').html(data['0'].Position);
            $('#NameDepartment').html(data['0'].NameDepartment);
            $('#NameSection').html(data['0'].NameSection);
            $('#NameCompany').html(data['0'].NameCompany);
            $('#Id_Card').val(data['0'].ID_Card);
        },
        error: function(jqXhr, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });

}

function changPaytype(val) {
    var tr = $(val).closest('tr');
    if (val.value == 2) {
        $(tr).find('td:eq(2) input').show();
        $(tr).find('td:eq(3) input').hide();
        $(tr).find('td:eq(4) input').hide();
    } else if (val.value == 1) {
        $(tr).find('td:eq(2) input').hide();
        $(tr).find('td:eq(3) input').show();
        $(tr).find('td:eq(4) input').show();
        console.log(val.value);
    }
}