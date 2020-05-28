(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('CreateCashOutCtrl', mk);

    mk.$inject = ['$scope', '$uibModalInstance','$player','$PlayerSvc','$actionTypeSvc','toastr'];

    function mk($scope, $uibModalInstance,$player,$playerSvc,$actionTypeSvc,toastr) {
        $scope.Title = "Tỉ lệ triết khấu khách hàng " + _.get($player,"Name");
        $scope.indexLine = -1;
        $scope.cashOutList = [];
        $scope.actionTypeList = [];
        $scope.actionTypePick = {};
        $scope.cashOut = {};
        $scope.actionTypePickToEdit = {};
        var vm = {};
        var formLoad = function () {
            $actionTypeSvc.getAll().then(function (items) {
                _.set($scope,"actionTypeList",items);
                $(function () {
                    vm.msCaPlayer = $('#ms-ca-action').magicSuggest({
                        data: $scope.actionTypeList,
                        expandOnFocus: true,
                        maxDropHeight: 145,
                        placeholder: 'Chọn loại chơi',
                        valueField: 'Id',
                        editable: false,
                        displayField: 'Name',
                        maxSelection: 1
                    });
                    $(vm.msCaPlayer).on('selectionchange', function () {
                        var temp = this.getSelection();
                        $scope.$apply(function () {
                            _.set($scope,"actionTypePick",_.clone(temp[0]));
                            console.log($scope.actionTypePick);
                        });
                    });

                });
            });
            var param = {PlayerId : $player.Id};
            $playerSvc.modalGetCashOutPostId(param).then(function (items) {
               if (_.get(items,"success")){
                    _.set($scope,"cashOutList",_.get(items,"data"));
               }
            });
        };
        formLoad();
        $scope.close = function () {
            $uibModalInstance.dismiss("close");
        }
        $scope.save = function () {
            $uibModalInstance.close();
        }
        $scope.createCashOut = function () {
            if (!_.get($scope,"actionTypePick.Id") || !_.get($scope,"cashOut.InCoin") || !_.get($scope,"cashOut.OutCoin")){
                toastr.warning("Chưa nhập đủ thông tin","Cảnh báo");
                return;
            }
            var cashOut = {
                ActionTypeId : _.get($scope,"actionTypePick.Id"),
                PlayerId:_.get($player,"Id"),
                InCoin : _.get($scope,"cashOut.InCoin"),
                OutCoin : _.get($scope,"cashOut.OutCoin")
            }
            $playerSvc.createCashOutApi(cashOut).then(function (items) {
                if(_.get(items,"success")){
                    toastr.success("Tỉ lệ đã được thêm mới thành công","Success");
                    formLoad();
                }
            });
        }
        function validateForm() {
            
        }
        $scope.editItem = function (index,item) {
            $scope.indexLine = index;
            $(function () {
                vm.msCaActionEdit = $('#ms-ca-action-edit-'+index).magicSuggest({
                    data: $scope.actionTypeList,
                    expandOnFocus: true,
                    maxDropHeight: 145,
                    placeholder: 'Chọn loại chơi',
                    valueField: 'Id',
                    editable: false,
                    displayField: 'Name',
                    maxSelection: 1
                });
                $(vm.msCaActionEdit).on('selectionchange', function () {
                    var temp = this.getSelection();
                    $scope.$apply(function () {
                        _.set($scope,"actionTypePickToEdit",_.clone(temp[0]));
                        console.log($scope.actionTypePickToEdit);
                    });
                });
                var selection = _.find($scope.actionTypeList,function (actt) {
                   return actt.Code == item.Code;
                });
                vm.msCaActionEdit.setSelection(selection);
                _.set($scope,"actionTypePickToEdit",selection);
            })
        };
        $scope.saveItem = function (item) {
            if (_.get(item,"Id") > 0){
                $scope.indexLine = -1;
                var cashOut = {
                    Id: _.get(item,"Id"),
                    ActionTypeId : _.get($scope,"actionTypePickToEdit.Id"),
                    PlayerId:_.get($player,"Id"),
                    InCoin : _.get(item,"InCoin"),
                    OutCoin : _.get(item,"OutCoin")
                }
                $playerSvc.updateCashOutApi(cashOut).then(function (item) {
                    console.log(item);
                })
            }else {

            }
        };
    }
})();
