/**
 * Created by Dev-1 on 21/07/2017.
 */
(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .factory('ActionTypeSvc', pl);

    pl.$inject = ['$http', '$q'];

    function pl($http, $q) {
        var service = {
            getById: getById,
            getAll:getAll,
            createActionType:createActionType,
            deleteItem:deleteItem,
            updatteItem:updatteItem
        };

        return service;
        function getAll() {
            var url = 'api-get-action-type';
            return getMethodService(url,null);
        }
        function getById(id) {

        }
        function createActionType(data) {
            var url = 'api-create-action-type/';
            return postMethodService(url,data);
        }
        function deleteItem(data) {
            var url = 'api-delete-action-type/';
            return postMethodService(url,data);
        }
        function updatteItem(data) {
            var url = 'api-update-action-type/';
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