/**
 * Created by DungNV44 on 8/1/2017.
 */
(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('CreateActionTypeCtrl', mk);

    mk.$inject = ['$scope', '$uibModalInstance'];

    function mk($scope, $uibModalInstance) {
        var formLoad = function () {

        };
        formLoad();
        $scope.close = function () {
            $uibModalInstance.dismiss("close");
        };
        $scope.save = function () {
            $uibModalInstance.close();
        }
    }
})();
