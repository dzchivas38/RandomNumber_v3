(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('ConfirmDeleteCtrl', mk);

    mk.$inject = ['$scope','$uibModalInstance','toastr'];

    function mk($scope,$uibModalInstance,toastr) {
        var formLoad = function () {
            var vm = {};
        }
        formLoad();
        $scope.close = function () {
            $uibModalInstance.close(false);
        }
        $scope.commit = function () {
            $uibModalInstance.close(true);
        }
    }
})();
