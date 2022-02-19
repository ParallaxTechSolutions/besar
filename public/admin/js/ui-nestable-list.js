$(function () {
    var updateOutput = function (e) {
        
        var list = e.length ? e : $(e.target), output = list.data('output');
         
        $.ajax({
            method: "POST",
            url: savelistURl,
            data: {
                list: list.nestable('serialize'),
                _token : token
            },
             beforeSend: function() {
                $("#nestable").waitMe({
                    effect : 'bounce',
                    text : '',
                    bg : 'rgba(255,255,255,0.7)',
                    color : '#000',
                    maxSize : '',
                    waitTime : -1,
                    textPos : 'vertical',
                    fontSize : '',
                    source : '',
                    onClose : function() {}
                });
            },
        }).fail(function(jqXHR, textStatus, errorThrown){
            alert("Unable to save new list order: " + errorThrown);
        }).done(function() {
          $("#nestable").waitMe('hide');
        });
    };

    // activate Nestable for list 1
    $('#nestable').nestable({
        group: 1
    }).on('change', updateOutput);

    // activate Nestable for list 2
    $('#nestable2').nestable({
        group: 2
    }).on('change', updateOutput);

    // output initial serialised data
    //updateOutput($('#nestable').data('output', $('#nestable-output')));
    updateOutput($('#nestable2').data('output', $('#nestable2-output')));

    $('#nestable-menu').on('click', function (e) {
        var target = $(e.target),
            action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });

    $('#nestable3').nestable();
});
