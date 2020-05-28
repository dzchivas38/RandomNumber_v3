/**
 * Created by DungNV44 on 8/1/2017.
 */
(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('CreateActionTypeCtrl', mk);

    mk.$inject = ['$scope', '$uibModalInstance','toastr','$actionType','ActionTypeSvc','blockUI'];

    function mk($scope, $uibModalInstance,toastr,$actionType,$actionTypeSvc,blockUI) {
        var formLoad = function () {
            blockUI.start();
            $scope.actionType = $actionType;
            $actionTypeSvc.getAll().then(function (items) {
                _.set($scope,"allItem",items);
                if (_.get($scope, "actionType.Id") > 0) {
                    $scope.Title = "Chỉnh sửa thông tin";
                    $scope.actionType = _.find(_.get($scope,"allItem"),function (item) {
                       return item.Id ==  $actionType.Id;
                    });
                    $scope.actionType.IsFirstChirld = ($scope.actionType.IsFirstChirld == 1) ? true:false;
                } else {
                    $scope.Title = "Thêm mới";
                }
                blockUI.stop();
            });
        };
        formLoad();
        $scope.close = function () {
            $uibModalInstance.dismiss("close");
        };
        $scope.save = function () {
            if (!_.get($scope,"actionType.Name") || !_.get($scope,"actionType.Code")){
                toastr.warning("Chưa nhập đủ thông tin","Cảnh báo");
                return;
            }

            if(_.get($scope,"actionType.Id") == 0){
                var duplicated = _.some($scope.allItem,function (item) {
                    return item.Code === _.get($scope,"actionType.Code");
                });
                if(duplicated){
                    toastr.warning("Cú pháp chuẩn đã tồn tại","Cảnh báo");
                    return;
                }
                var actionType = {
                    Name: _.get($scope,"actionType.Name"),
                    ActionTypeLevel: _.get($scope,"actionType.ActionTypeLevel"),
                    IsFirstChirld: _.get($scope,"actionType.IsFirstChirld"),
                    Description: _.get($scope,"actionType.Description"),
                    Code: _.get($scope,"actionType.Code"),
                    Unit: "n",
                };
                $actionTypeSvc.createActionType(actionType).then(function (items) {
                    if(_.get(items,"success")){
                        toastr.success("Thêm mới thành công","Success");
                        return items;
                    }else{
                        toastr.error("Đã có lỗi xảy ra, vui lòng liên hệ administrator để được hỗ trợ","ERROR 404");
                    }
                });
            }else {
                $actionTypeSvc.updatteItem($scope.actionType).then(function (item) {
                    if(_.get(item,"success")){
                        toastr.success("Thêm mới thành công","Success");
                        return item;
                    }else{
                        toastr.error("Đã có lỗi xảy ra, vui lòng liên hệ administrator để được hỗ trợ","ERROR 404");
                    }
                });
            }
            $uibModalInstance.close();
        }
    }
})();
