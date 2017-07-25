(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('PlayerListController', PlayerListController);

    PlayerListController.$inject = ['$scope','PlayerSvc','$uibModal','toastr'];

    function PlayerListController($scope,$playerSvc,$uibModal,toastr) {
        $scope.title = 'PlayerListController';

        var formLoad = function ()
        {
            $playerSvc.getAll().then(function (item) {
                console.log(item);
            });
        }
        formLoad();
        $scope.createPlayerUi = function () {
            return $uibModal
                .open({
                    templateUrl: "template/Modal/playerForm.html",
                    controller: "CreatePlayerCtrl",
                    size: "lg",
                    resolve: {
                        $player: { Id: 0 }
                    }
                })
                .result.then(function (result) {
                    $playerSvc.createPlayer(result).then(function (item) {
                        if (_.get(item, "success")) {
                            toastr.success("OK", 'Thành công');
                            formLoad();
                        } else {
                            toastr.error("Fail".ERROR, 'Lỗi');
                        }
                    });
                })
                .catch(function (e) {
                    console.log(e);
                });
        }
    }
})();
