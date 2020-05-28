(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .factory('SyntaxSvc', pl);

    pl.$inject = ['$http', '$q'];

    function pl($http, $q) {
        var service = {
            getById: getById,
            getAll:getAll,
            createSyntax:createSyntax,
            deleteItem:deleteItem,
            updateItem:updateItem,
        };

        return service;
        function getAll() {
            var url = 'api-get-syntax';
            return getMethodService(url,null);
        }
        function createSyntax(data) {
            var url = 'api-create-syntax/';
            return postMethodService(url,data);
        }
        function deleteItem(data) {
            var url = 'api-delete-syntax/';
            return postMethodService(url,data);
        }
        function updateItem(data) {
            var url = 'api-update-syntax/';
            return postMethodService(url,data);
        }
        function getById(data) {
            var url = 'api-get-syntax-by-id/';
            return postMethodService(url,data);
        }
        function getMethodService(restUrl,data) {
            var dfd = $q.defer();
            $http.get(restUrl, data,
                {
                    headers: {
                        "Accept": "application/json;odata=verbose",
                        "Content-Type": "application/json"
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
            $http.post(restUrl, data,
                {
                    headers: {
                        "Accept": "application/json;odata=verbose",
                        "Content-Type": "application/json"
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
    }
})();