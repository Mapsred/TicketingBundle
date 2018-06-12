
$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();



    $(".select2").select2({
        language: 'fr'
    });

    $(".select2-tags").select2({
        tags: true,
        language: 'fr'
    });

    $(".datepicker").datepicker({
        format: "dd/mm/yyyy",
        todayBtn: "linked",
        language: "fr",
        clearBtn: true,
        autoclose: true,
        todayHighlight: true
    });
});