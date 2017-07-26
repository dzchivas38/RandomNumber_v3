/**
 * Created by DungNV44 on 7/26/2017.
 */
(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('ActionTypeController', ActionTypeController);

    ActionTypeController.$inject = ['$scope'];

    function ActionTypeController($scope) {
        $scope.title = 'ActionTypeController';
        formLoad();
        function formLoad() {

        };
    }
})();
