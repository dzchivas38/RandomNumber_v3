(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .factory('CalculatorSvc', pl);

    pl.$inject = ['$http', '$q','blockUI'];

    function pl($http, $q,blockUI) {
        var service = {
            process:process,
        };

        return service;
        //hàm gọi API tính toán kết quả
        function process(data) {
            var url = 'api-get-calculator-process/';
            return postMethodService(url,data);
        }
        function getMethodService(restUrl,data) {
            var dfd = $q.defer();
            $http.get(restUrl, data,
                {
                    headers: {
                        "Accept": "application/json;odata=verbose",
                        "Content-Type": "application/json",
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                })
                .then(function onSuccess(response) {
                    dfd.resolve(_.get(response, "data"));
                })
                .catch(function onError(response) {
                    console.log(response);
                    dfd.resolve(null);
                });
            return dfd.promise;
        }
        function postMethodService(restUrl,data) {
            var dfd = $q.defer();
            blockUI.start("Đang tải ...!");
            $http.post(restUrl, data,
                {
                    headers: {
                        "Accept": "application/json;odata=verbose",
                        "Content-Type": "application/json",

                    },
                })
                .then(function onSuccess(response) {
                    blockUI.stop();
                    dfd.resolve(_.get(response, "data"));
                })
                .catch(function onError(response) {
                    console.log(response);
                    blockUI.stop();
                    dfd.resolve(response);
                });
            return dfd.promise;
        }
    }
})();