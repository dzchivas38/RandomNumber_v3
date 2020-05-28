(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('PlayerListController', PlayerListController);

    PlayerListController.$inject = ['$scope','PlayerSvc','ActionTypeSvc','$uibModal','toastr'];

    function PlayerListController($scope,$playerSvc,$actionTypeSvc,$uibModal,toastr) {
        $scope.title = 'PlayerListController';
        $scope.players = [];
        var formLoad = function ()
        {
            $playerSvc.getAll().then(function (items) {
                _.set($scope,"players",items)
            });
        }
        formLoad();
        $scope.createPlayerUi = function (Id) {
            var _Id = (Id > 0) ? Id : 0;
            return $uibModal
                .open({
                    templateUrl: "template/Modal/playerForm.html",
                    controller: "CreatePlayerCtrl",
                    size: "lg",
                    resolve: {
                        $player: { Id: _Id }
                    }
                })
                .result.then(function (result) {
                    console.log(result);
                    formLoad();
                })
                .catch(function (e) {
                    console.log(e);
                });
        }
        $scope.cashOutInfo = function (playerId) {
            return $uibModal
                .open({
                    templateUrl: "template/Modal/cashOutForm.html",
                    controller: "CreateCashOutCtrl",
                    size: "lg",
                    resolve: {
                        $player: playerId,
                        $PlayerSvc : $playerSvc,
                        $actionTypeSvc:$actionTypeSvc
                    }
                })
                .result.then(function (result) {

                })
                .catch(function (e) {
                    console.log(e);
                });
        }
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
                            $playerSvc.deleteItem(obj).then(function (item) {
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
