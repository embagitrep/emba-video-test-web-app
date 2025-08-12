function formErrorGenerator(el, errors, showErrors = false) {
    $.each(errors, function (index, error) {
        if (index.includes('.'))
            index = convertToBracketNotation(index)

        let inp = el.find('input[name="'+index+'"]');

        if (inp.attr('type') === 'checkbox' || inp.attr('type') === 'radio' || inp.attr('type') === 'file') {
            inp.parents('label').addClass('has-error');
        }else{
            inp.addClass('has-error');

            if(showErrors) {
                inp.parent()
                    .append('<p class="text--red text--12 mb--12 text-w--500 flex flex--align-center mt--10 js--error">' +
                        '<span class="icons icons--danger mr--8"></span>' +
                        error +' '+
                        '</p>');
            }
        }

        if (!showErrors) {
            el.find('select[name="'+index+'"]').addClass('has-error');
        }else {
            el.find('select[name="'+index+'"]').parent()
                .append('<p class="text--red text--12 mb--12 text-w--500 mt--10 flex flex--align-center js--error">' +
                    '<span class="icons icons--danger mr--8"></span>' +
                    error +' '+
                    '</p>');
        }
    })
}

function convertToBracketNotation(str) {
    return str.replace(/\.(\d+)/g, '][$1]')
            .replace(/\./g, '[')
            .replace(']', '')
        +']';
}

export default formErrorGenerator;