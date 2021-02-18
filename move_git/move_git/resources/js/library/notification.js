
/**
 * Created by tung.lethanh1294 on 02/03/2018.
 */
// Declare a function known as Immediately-Invoked-Function-Expressions IIFE
// create new scope and create privacy

var notification = (function($){
    // return an anonymous Object Literal

    function _init(){
        $('.toast').toast({
            animation: true,
            autohide: true,
            delay: 3000
        });
    }

    function _reset(){
        $('#toast-notification .alert').removeClass('alert-success');
        $('#toast-notification .alert').removeClass('alert-danger');
        $('#toast-notification .alert').removeClass('alert-warning');
        $('#toast-notification .alert-body .message-list').remove();
    }

    function _build(messageList, headerText, option){
        var message = '<ol class="message-list" value="1">';
        for(var i = 0; i < messageList.length; i++){
            message += '<li>'+ messageList[i] +'</li>'
        }
        message += '</ol>';
        if(option.typeMessage){
            $('#toast-notification .alert').addClass(option.typeMessage);
        }
        $('#toast-notification .type-message')[0].innerHTML = headerText;
        $('#toast-notification .alert-body').append(message);
    }

    _init();

    return {
        showWarning: function(messageList, option = {}){
            _reset();
            var headerText = 'Cảnh Báo';
            var optionM = {
              typeMessage: 'alert-warning'
            };
            _build(messageList, headerText, optionM);
            $('#toast-notification').toast('show');
        },
        showError: function(messageList, option = {}){
            _reset();
            var headerText = 'Lỗi';
            var optionM = {
                typeMessage: 'alert-danger'
            };
            _build(messageList, headerText, optionM);
            $('#toast-notification').toast('show');
        },
        showSuccess: function(messageList, option = {}){
            _reset();
            var headerText = 'Thành Công';
            var optionM = {
                typeMessage: 'alert-success'
            };
            _build(messageList, headerText, optionM);
            $('#toast-notification').toast('show');
        },
        hide: function(dataRequest, action){
            $('#toast-notification').toast('hide');
        },
    };

    //};
})(jQuery);

