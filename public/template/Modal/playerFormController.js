(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('CreatePlayerCtrl', mk);

    mk.$inject = ['$scope', 'PlayerSvc', '$uibModalInstance','$player'];

    function mk($scope, $playerSvc, $uibModalInstance,$player) {
        var formLoad = function () {
            $scope.player = $player;
            if (_.get($scope, "player.Id") > 0) {
                $scope.Title = "Chỉnh sửa thông tin khách hàng";
            } else {
                $scope.Title = "Thêm mới khách hàng";
            }
        }
        formLoad();
        $scope.close = function () {
            $uibModalInstance.dismiss("close");
        }
        $scope.save = function () {
            $uibModalInstance.close();
        }
    }
})();
