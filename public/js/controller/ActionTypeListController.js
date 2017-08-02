/**
 * Created by DungNV44 on 7/26/2017.
 */
(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('ActionTypeController', ActionTypeController);

    ActionTypeController.$inject = ['$scope','$uibModal','toastr'];

    function ActionTypeController($scope,$uibModal,toastr) {
        $scope.title = 'ActionTypeController';
        formLoad();
        function formLoad() {

        };
        $scope.createActionTypeUi = function () {
            return $uibModal
                .open({
                    templateUrl: "template/Modal/actionsTypeForm.html",
                    controller: "CreateActionTypeCtrl",
                    size: "lg",
                    resolve: {
                        $actionType: { Id: 0 }
                    }
                })
                .result.then(function (result) {
                    toastr.success("OK", 'Thành công');
                })
                .catch(function (e) {
                    console.log(e);
                });
        };
    }
})();
