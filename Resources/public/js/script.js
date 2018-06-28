const Table = {
    init: function () {
        $('.data-table').each(function () {
            let table = Table.initTable(this, $(this).data('status'), $(this).data('type'));
            let parent = $(this).closest('.box-body');
            $(parent).find('.dataTables_wrapper').on('keyup', ".column_search", function () {
                table.column($(this).parent().index()).search(this.value).draw();
            });

        });
    },

    initTable: function (dataTable, status, type) {
        $(dataTable).find('tfoot th').each(function () {
            let title = $(this).text();
            let disabled = $(this).hasClass('disabled') ? 'disabled' : '';

            $(this).html('<input type="text" class="form-control column_search" style="width: 100%" ' +
                'placeholder="' + title + '" ' + disabled + ' />');
        });

        return $(dataTable).DataTable({
            "order": [[0, "desc"]],
            "scrollX": true,
            "processing": true,
            "serverSide": true,
            "searchDelay": 350,
            "bDeferRender": true,
            "ajax": Routing.generate('ticketing_ajax_datatable', {status: status, type: type}, false),
            'language': {
                "sProcessing": "Traitement en cours...",
                "sSearch": "Rechercher selon n'importe quel critère&nbsp;:",
                "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
                "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                "sInfoPostFix": "",
                "sLoadingRecords": "Chargement en cours...",
                "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
                "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
                "oPaginate": {
                    "sFirst": "Premier",
                    "sPrevious": "Pr&eacute;c&eacute;dent",
                    "sNext": "Suivant",
                    "sLast": "Dernier"
                },
                "oAria": {
                    "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                    "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                }
            },
            "sPaginationType": "full_numbers",
            "aoColumns": [null, null, null, null, null, null, null, null],
            "columnDefs": [
                {
                    targets: 0,
                    name: 'id',
                    className: "",
                    render: function (data, type, row) {
                        return "<a href='" + Routing.generate('ticketing_detail', {id: data}) + "'>#" + data + "</a>";
                    }
                },
                {
                    targets: 1,
                    name: 'author',
                    className: "",
                    render: function (data, type, row) {
                        return data;
                    }
                },
                {
                    targets: 2,
                    name: 'createdAt',
                    className: "",
                    render: function (data, type, row) {
                        return data;
                    }
                },
                {
                    targets: 3,
                    name: 'category',
                    className: "",
                    render: function (data, type, row) {
                        return data;
                    }
                },
                {
                    targets: 4,
                    name: 'status',
                    className: "",
                    render: function (data, type, row) {
                        data = data.split(' - ');
                        const color = data[1];

                        return "<div class='label bg-" + color + "'>" + data[0] + "</div>";
                    }
                },
                {
                    targets: 5,
                    name: 'type',
                    className: "",
                    render: function (data, type, row) {
                        return data;
                    }
                },
                {
                    targets: 6,
                    name: 'assignated',
                    className: "",
                    render: function (data, type, row) {
                        return data;
                    }
                },
                {
                    targets: 7,
                    name: 'priority',
                    className: "",
                    render: function (data, type, row) {
                        return data;
                    }
                },
            ],
        });
    },
};

const Detail = {
    init: function () {
        $('#change_category').on('shown.bs.modal', function () {
            Detail.categories();
        });

        $("#status_btn").unbind('click').bind('click', function () {
            Detail.status($(this).data("id"));
        });
    },

    categories: function () {
        const route = Routing.generate("ticketing_ajax_categories");
        $.ajax({
            url: route,
            type: "GET",
            data: {'cat': true},
            success: function (res) {
                Detail.treatment(res.categories);
            }
        });
    },

    treatment: function (data) {
        let select = "<select class=\"form-control\" id='cat_select'>";

        $.each(data, function (key, value) {
            select += "<option>" + value + "</option>";
        });

        select += "</select>";

        $("#cat_modal_body").html(select);

        $("#cat_validate").click(function () {
            const id = $("#cat_btn").data("id");
            const selectMenu = document.getElementById('cat_select');
            const cat = selectMenu.options[selectMenu.selectedIndex].text;

            $('#change_category').modal('hide');
            const catTd = $("#cat");
            const old = catTd.html();
            $("#flashbag").html("<div class=\"alert alert-success\">" +
                "Catégorie changée de " + old + " à " + cat + "</div>");

            catTd.html(cat);
            Detail.changeCategory(cat, id);
        });
    },

    changeCategory: function (cat, id) {
        const route = Routing.generate("ticketing_ajax_cat_change");
        $.ajax({
            url: route,
            type: "POST",
            data: {'cat': cat, id: id},
            success: function (res) {
            }
        });
    },

    status: function (id) {
        const route = Routing.generate("ticketing_ajax_status_update");
        $.ajax({
            url: route,
            type: "POST",
            data: {'id': id},
            success: function () {
                window.location.reload();
            }
        });
    }
};

//TODO
const Rating = {
    init: function () {
        Rating.create($("#rating-input"));

        $("#rating-input").on("rating.change", function (event, value) {
            $(this).rating('destroy').prop('readonly', true);
            Rating.create(this);
            Rating.send($("#rating-box"), value, $("#rating-box").data('ticket'));
        });
    },

    create: function (object) {
        $(object).rating({
            min: $(object).data('min'),
            max: $(object).data('max'),
            step: $(object).data('step'),
            size: $(object).data('size'),
            showClear: $(object).data('show-clear'),
            showCaption: $(object).data('show-caption'),
            readonly: $(object).prop('readonly')
        });
    },

    send: function (rating_box, rating, ticket) {
        const outputDiv = $($(rating_box).next());
        $.ajax({
            type: "POST",
            url: Routing.generate("ajax_rating_add"),
            data: {rating: rating, ticket: ticket},
            success: function (res) {
                outputDiv.html(res['success']);
                outputDiv.addClass('text-success');
            }
        });
    }
};

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

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


    $('[data-provider="select2"]').select2({
        language: 'fr'
    });

    Table.init();

    if (document.getElementById("cat")) {
        Detail.init();
    }

    if (document.getElementById("rating-input")) {
        Rating.init();
    }
});