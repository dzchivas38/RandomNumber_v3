/**
 * Created by Dev-1 on 21/07/2017.
 */
(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .factory('PlayerSvc', pl);

    pl.$inject = ['$http', '$q'];

    function pl($http, $q) {
        var service = {
            getById: getById,
            getAll:getAll,
            createPlayer:createPlayer
        };

        return service;
        function getAll() {
            var url = 'api-get-player';
            return getMethodService(url,null);
        }
        function getById(id) {

        }
        function createPlayer() {
            var result= {
                success:true
            };
            return result;
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
                    dfd.resolve(_.get(response, "data.d"));
                })
                .catch(function onError(response) {
                    console.log(response);
                    dfd.resolve(null);
                });
            return dfd.promise;
        }
    }
})();