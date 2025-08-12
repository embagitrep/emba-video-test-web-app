$('.js--renderAttrModal').click(function (e) {
    e.preventDefault();
    let url = $(this).attr('href');
    $.ajax({
        url: url,
        complete:function (data) {
            let res = data.responseJSON;
            if (res.success){
                $('body').append(res.html)
                $(document).find('#add-attr-modal').modal('show')
                $(document).find('#add-attr-modal').on('hidden.bs.modal', function () {
                    $(this).remove()
                });
            }
        }
    })

});



$(document).on('click', '.js--loadAttrSet',function (e) {
    e.preventDefault();
    let url = $(this).attr('href');
    $.ajax({
        url: url,
        complete: function (data) {
            let res = data.responseJSON;
            if (res.success){
                $(document).find('.js--attrSetItems').append(res.html)
            }
        }
    })
})

var attrCounter = 0;
$(document).on('change','.js--attributeSetSelect', function (e) {
    e.preventDefault();
    let val = $(this).val(), url = $(this).find(':selected').data('url');

    if ($(this).val()=='')return;

    url +='?index='+attrCounter

    console.log(attrCounter)
    $.ajax({
        url: url,
        complete: function (data) {
            let res = data.responseJSON;
            if (res.success){
                $(document).find('.js--attrSetItems').append(res.html);
                attrCounter++;
            }
        }
    })
});
$(document).on('submit','.js--addAttr', function (e) {
    e.preventDefault();
    let _this = $(this), formData = _this.serialize(), url = _this.attr('action');

    $.ajax({
        url: url,
        type:'post',
        data: formData,
        complete:function (data) {
            let res = data.responseJSON;
            if (res.errors != 'undefined'){
                $.each(res.errors, function (i,v) {
                    let inpName = i.replace(/\.(.+?)(?=\.|$)/g, (m, s) => `[${s}]`);
                    _this.find('[name^="'+inpName+'"]').css('border-color','red')
                })

                toastr.error(res.message,{
                    timeOut: 5000
                });
            }
            if (res.success){
                $(document).find('#add-attr-modal').modal('hide')
                // $(document).find('#add-attr-modal').remove();
            }
        }
    })
})
