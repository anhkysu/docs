
/**
 * Created by tung.lethanh1294 on 02/03/2018.
 */
// Declare a function known as Immediately-Invoked-Function-Expressions IIFE
// create new scope and create privacy

var http = (function($){
    // return an anonymous Object Literal

    var $self = this;

    $self.domain = '';
    $self.url = '';

    function _getRootUrl() {
        var defaultPorts = {"http:":80,"https:":443};

        return window.location.protocol + "//" + window.location.hostname
            + (((window.location.port)
            && (window.location.port != defaultPorts[window.location.protocol]))
                ? (":"+window.location.port) : "");
    };

    function _failCallBack(data, error){
        switch(data.status){
            case 500:
                var messageList = [];
                messageList.push(data.statusText);
                notification.showError(messageList);
                break;
            case 403:
            case 401:
                var messageList = [];
                messageList.push(data.statusText);
                notification.showError(messageList);
                break;
                break;
        }
    }

    return {
        get: function(action, doneCallbank, async){
            var responseFunc = $.ajax({
                method: 'GET',
                url: $self.domain + action,
            });
            responseFunc.done(doneCallbank)
            .fail(_failCallBack);
        },
        post: function(dataRequest, action, doneCallbank){
            var responseFunc = $.ajax({
                method: 'POST',
                url:  $self.domain + action,
                data: JSON.stringify(dataRequest),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
            });
            responseFunc.done(doneCallbank)
            .fail(_failCallBack);
        },
        put: function(dataRequest, action, doneCallbank){
            var responseFunc = $.ajax({
                method: 'PUT',
                url:  $self.domain + action,
                data: JSON.stringify(dataRequest),
                contentType: "application/json; charset=utf-8",
                dataType: "json",

            });
            responseFunc.done(doneCallbank)
            .fail(_failCallBack);

        },
        patch: function(dataRequest, action, doneCallbank){
            var responseFunc = $.ajax({
                method: 'PATCH',
                url: $self.domain + action,
                data: JSON.stringify(dataRequest),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
            });
            responseFunc.done(doneCallbank)
            .fail(_failCallBack);
        },
        delete: function(dataRequest, action, doneCallbank){
            var responseFunc = $.ajax({
                method: 'DELETE',
                url: $self.domain + action,
                contentType: "application/json; charset=utf-8",
                dataType: "json",
            });
            responseFunc.done(doneCallbank)
            .fail(_failCallBack);
        },
        generateURLWithStringQuery: function(action, stringQueryObj){
            var queryString = '';
            for(var attr in stringQueryObj){
                queryString += attr + '=' +stringQueryObj[attr] + '&';
            }
            queryString = queryString.slice(0, queryString.length-1);
            return $self.domain + action + '?' + queryString;
        },
        upload: function(dataRequest, action, doneCallbank){
            var responseFunc = $.ajax({
                method: 'POST',
                url: $self.domain + action,
                contentType: false,
                processData: false,
                enctype: 'multipart/form-data',
                data: dataRequest,
            });
            responseFunc.done(doneCallbank)
            .fail(_failCallBack);
        },
    };

    //};
})(jQuery);

