$(document).ready(function () {
    // jQuery(".chosen-select").chosen({'width': '100%', 'white-space': 'nowrap'});
    $('.contextpanel .glyphicon-remove').on('click', function () {
        $('.actionpanel').hide();
    })
    $('.contextpanel').on('click', function (e) {
        e.stopPropagation();
    })
    $('.leftpanelinner').on('click', function (e) {
        e.stopPropagation();
    })
    $('html').on('click', function (e) {
        $('.contextpanel').hide();
    })
    $('.actionpanel .panel-body').on('click', '.magnum-ajax.magnum-togglevisibility', function (e) {
        e.preventDefault();
        jQuery.ajax({
            'url': $(this).attr('href'),
            'dataType': 'json',
            'success': function (data) {
                $('#' + jQuery('.contextpanel1 .panel-tree').jstree('get_selected')).removeClass('menus-hidden menus-visible').addClass(data.class);
            }
        });
    });
    $('.actionpanel .panel-body').on('click', '.magnum-ajax.magnum-jstree-create', function (e) {
        // e.preventDefault();
        // jstree_create();
    });

    $('.actionpanel .panel-body').on('click', '.magnum-ajax.magnum-delete', function (e) {
        e.preventDefault();

        if (!confirm("Are you sure you want to delete this item?")) {
            return;
        }

        jQuery.ajax({
            'url': $(this).attr('href'),
            'dataType': 'json',
            'success': function (data) {
                $('.contextpanel1 .panel-tree').jstree('refresh');
            }
        });
    });



    $('.js--getTree').on('click', function (e) {
        $('.contextpanel1').show();
        e.preventDefault();
        $('.sidebaritems a').removeAttr('jstree-openned');
        $('.contextpanel1 .panel-tree').jstree('destroy');
        $(this).attr('jstree-openned', 1);
        $('.contextpanel1 .panel-tree').on('changed.jstree', function (e, data) {
            var i, j, r = [];
            for (i = 0, j = data.selected.length; i < j; i++) {
                r.push(data.instance.get_node(data.selected[i]).text);
            }
            $('.actionpanel .panel-body').html('Selected: ' + r.join(', '));
            $.ajax({'url': $('.sidebaritems a[jstree-openned=1]').attr('jstree-getaction'),
                'data': {'id': data.instance.get_node(data.selected[0]).id},
                'dataType': 'html',
                'success': function (data) {
                    $('.actionpanel .panel-body').html(data);
                    $('.actionpanel').show();
                    $('.actionpanel').css('left', $('.main-menu').width() + $('.contextpanel1').width() + 'px');
                }
            });

        }).on('move_node.jstree', function (e, d) {
            //alert(d);
            $.ajax({
                'url': $('.sidebaritems a[jstree-openned=1]').attr('jstree-changeparent'),
                'data': {
                    'menuArr': jQuery('.contextpanel1 .panel-tree').jstree().get_node('#' + d.node.parent).children,
                    'id': d.node.id,
                    'new_parent': d.parent,
                    'sort': d.position,
                },
                'dataType': 'json',
                'success': function (data) {
                    if (data.message == 'error') {
                        alert('Error occured. Please refresh and retry!');
                    }
                }
            })
        }).
        jstree({
            'core': {
                "animation": 0,
                "check_callback": true,
                'data': {
                    'url': $(this).attr('href'),
                    'dataType': 'JSON',
                    'data': function (node) {
                        return {'id': node.id};
                    }
                },
                'themes': {
                    'responsive': true,
                    "stripes": false
                }
            },
            'plugins': ['dnd', 'state', 'crrm', 'core', 'themes', 'types', 'wholerow'],
            "types": {
                "#": {
                    "valid_children": ["root", 'recycle'],
                },
                "root": {
                    "valid_children": ["default", 'file'],
                    //'icon':'fa-plus-square fa'
                    'icon': 'fa'
                },
                'recycle': {
                    'valid_children': ['deleted']
                },
                'deleted': {
                    'valid_children': ['deleted']
                },
                "default": {
                    "valid_children": ["default", "file"]
                },
                "file": {
                    "valid_children": ['file', 'default', 'item', 'article'],
                    'icon': "bx bx-dots-vertical"
                },
                "article": {
                    "valid_children": [],
                    'icon': "fa fa-file-text-o"
                },
                'item': {
                    'valid_children': [],
                    'icon': "glyphicon glyphicon-barcode"
                }
            },
        });
    });
});


function jstree_create() {
    var ref = $('.contextpanel1 .panel-tree').jstree(true),
        sel = ref.get_selected();
    if (!sel.length) {
        return false;
    }
    sel = sel[0];
    //str1 = $('.contextpanel1 .panel-tree').jstree(true).get_selected();
    str1 = sel;
    parent_id = parseInt(str1.replace(/[A-Za-z$-]/g, ""));
    parent_type = str1.replace(/[0-9$-]/g, "");

    if (parent_type == 'root')
        parent_id = -1 * parent_id;
    dataValues = {};
    dataValues['ajax'] = 1;
    dataValues[$('.sidebaritems a[jstree-openned=1]').attr('data-module') + '[sort]'] = $('.contextpanel1 .panel-tree').jstree(true).get_node(sel).children.length + 1;
    dataValues[$('.sidebaritems a[jstree-openned=1]').attr('data-module') + '[parent_id]'] = parent_id;
    console.log($('.sidebaritems a[jstree-openned=1]').attr('jstree-createchild'))
    // window.location = $('.sidebaritems a[jstree-openned=1]').attr('jstree-createchild')

    $.ajax({'url': $('.sidebaritems a[jstree-openned=1]').attr('jstree-createchild'),
        'dataType': 'json',
        'type': 'GET',
        'data': dataValues,
        'success': function (data) {
            if (data.message == 'success')
                $('.contextpanel1 .panel-tree').jstree(true).refresh();
            else
                window.location.reload();
        }
    });
}
