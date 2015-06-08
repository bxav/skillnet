(function() {
    var app = angular.module('helloWorld', []);

    app.controller('HelloController', function(){
        this.message = "Hello World";
    });
})();