/**
 * Created by DungNV44 on 7/26/2017.
 */
(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('ActionTypeController', ActionTypeController);

    ActionTypeController.$inject = ['$scope','$uibModal','toastr','ActionTypeSvc'];

    function ActionTypeController($scope,$uibModal,toastr,$actionTypeSvc) {
        $scope.title = 'ActionTypeController';
        $scope.actionsTypes = [];
        formLoad();
        function formLoad() {
            $actionTypeSvc.getAll().then(function (items) {
                _.set($scope,"actionsTypes",items);
                console.log(items);
            });
        };
        $scope.createActionTypeUi = function (Id) {
            var actId = (Id > 0) ? Id : 0;
            return $uibModal
                .open({
                    templateUrl: "template/Modal/actionsTypeForm.html",
                    controller: "CreateActionTypeCtrl",
                    size: "lg",
                    resolve: {
                        $actionType: { Id: actId },
                    }
                })
                .result.then(function (result) {
                    formLoad();
                })
                .catch(function (e) {
                    console.log(e);
                });
        };
        $scope.delteItem = function (Id) {
            if (Id > 0){
                return $uibModal
                    .open({
                        templateUrl: "template/Modal/confirmDelete.html",
                        controller: "ConfirmDeleteCtrl",
                        size: "sm",
                        resolve: {

                        }
                    })
                    .result.then(function (result) {
                        if (result){
                            var obj = {Id : Id};
                            $actionTypeSvc.deleteItem(obj).then(function (item) {
                               if (item.success > 0){
                                   toastr.success("Success","Xóa bản ghi thành công");
                                   formLoad();
                               }else {
                                   toastr.watch("warning","Không có bản ghi nào được xóa !");
                               }
                            });
                        }else {

                        }
                    })
                    .catch(function (e) {
                        console.log(e);
                    });
            }
        }
    }
})();
