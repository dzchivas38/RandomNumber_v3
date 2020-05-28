(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('CreatePlayerCtrl', mk);

    mk.$inject = ['$scope', 'PlayerSvc', '$uibModalInstance','$player','toastr'];

    function mk($scope, $playerSvc, $uibModalInstance,$player,toastr) {
        var formLoad = function () {
            $scope.player = $player;
            if (_.get($scope, "player.Id") > 0) {
                $scope.Title = "Chỉnh sửa thông tin khách hàng";
                $playerSvc.getById({Id:$player.Id}).then(function (item) {
                   _.set($scope,"player",item[0]);
                });
            } else {
                $scope.Title = "Thêm mới khách hàng";
            }
        }
        formLoad();
        $scope.close = function () {
            $uibModalInstance.dismiss("close");
        }
        $scope.save = function () {
            if (!_.get($scope,"player.Name")){
                toastr.warning("Chưa nhập đủ thông tin","Cảnh báo");
                return;
            }
            if (_.get($scope, "player.Id") > 0) {
                $playerSvc.updateItem($scope.player).then(function (item) {
                    if(_.get(item,"success")){
                        toastr.success("Khách hàng đã được cập nhật thành công","Success");
                        formLoad();
                    }else{
                        toastr.error("Đã có lỗi xảy ra, vui lòng liên hệ administrator để được hỗ trợ","ERROR 404");
                    }
                });
            }else {
                var player = {
                    Name: _.get($scope,"player.Name"),
                    PhoneNumber: _.get($scope,"player.PhoneNumber"),
                    PlayerTypeId: 0,
                    isDelete: 0,
                    Description: _.get($scope,"player.Description"),
                };
                $playerSvc.createPlayer(player).then(function (items) {
                    if(_.get(items,"success")){
                        toastr.success("Khách hàng đã được thêm mới thành công","Success");
                        formLoad();
                    }else{
                        toastr.error(items,"ERROR");
                    }
                });
            }
            $uibModalInstance.close();
        }
    }
})();
