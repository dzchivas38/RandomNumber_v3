/**
 * Created by Dev-1 on 21/07/2017.
 */
/**
 * Created by Dev-1 on 21/07/2017.
 */
(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('SyntaxListController', SyntaxListController);

    SyntaxListController.$inject = ['$scope','SyntaxSvc','$uibModal','toastr'];

    function SyntaxListController($scope,$SyntaxSvc,$uibModal,toastr) {
        $scope.title = 'SyntaxListController';
        $scope.syntaxList = [];
        formLoad();
        function formLoad() {
            $SyntaxSvc.getAll().then(function (items) {
               console.log(items);
               _.set($scope,"syntaxList",items);
            });
        };
        $scope.createSyntaxUi = function (Id) {
            var _Id = (Id > 0 ) ? Id : 0;
            return $uibModal
                .open({
                    templateUrl: "template/Modal/syntaxForm.html",
                    controller: "CreateSyntaxCtrl",
                    size: "lg",
                    resolve: {
                        $syntax: { Id: _Id },
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
                            $SyntaxSvc.deleteItem(obj).then(function (item) {
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
