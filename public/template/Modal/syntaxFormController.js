(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('CreateSyntaxCtrl', mk);

    mk.$inject = ['$scope', 'SyntaxSvc', '$uibModalInstance','$syntax','toastr','ActionTypeSvc'];

    function mk($scope, $syntaxSvc, $uibModalInstance,$syntax,toastr,$actionTypeSvc) {
        var formLoad = function () {
            var vm = {};
            $scope.syntax = $syntax;
            $scope.msCaSyntax = null;
            $scope.actpList = [];
            if (_.get($scope, "syntax.Id") > 0) {
                $scope.Title = "Chỉnh sửa thông tin cú pháp";
            } else {
                $scope.Title = "Thêm mới cú pháp";
            }
            $(function () {
                $actionTypeSvc.getAll().then(function (items) {
                    _.set($scope,"actpList",items);
                     vm.msCaSyntax = $('#ms-ca-action-type').magicSuggest({
                        data: $scope.actpList,
                        expandOnFocus: true,
                        maxDropHeight: 145,
                        placeholder: 'Cú pháp chuẩn',
                        valueField: 'Id',
                        editable: false,
                        displayField: 'Name',
                        maxSelection: 1
                    });
                    $(vm.msCaSyntax).on('selectionchange', function () {
                        var temp = this.getSelection();
                        _.set($scope,"syntax.ActionTypeId",_.clone(_.get(temp[0],"Id")));
                        _.set($scope,"syntax.SyntaxForm",_.clone(_.get(temp[0],"Code")));
                    });
                    if (_.get($scope,"syntax.Id") > 0){
                        $syntaxSvc.getById({Id:_.get($scope,"syntax.Id")}).then(function (item) {
                            _.set($scope,"syntax",item[0]);
                            var selection = _.find($scope.actpList,function (actp) {
                               return actp.Code == item[0].SyntaxForm;
                            });
                            if (_.get(selection,"Id") > 0){
                                vm.msCaSyntax.setSelection(selection);
                            }
                        });
                    }
                });
            });
        }
        formLoad();
        $scope.close = function () {
            $uibModalInstance.dismiss("close");
        }
        $scope.save = function () {
            if (!_.get($scope,"syntax.Name")){
                toastr.warning("Chưa nhập đủ thông tin","Cảnh báo");
                return;
            }
            if (_.get($scope,"syntax.Id") > 0){
                $syntaxSvc.updateItem($scope.syntax).then(function (synx) {
                    if(_.get(items,"success")){
                        toastr.success("Cú pháp đã được thêm mới thành công","Success");
                        formLoad();
                    }else{
                        toastr.error(synx,"ERROR 404");
                    }
                });
            }else{
                var syntax = {
                    Name: _.get($scope,"syntax.Name"),
                    ActionTypeId: _.get($scope,"syntax.ActionTypeId"),
                    Description: _.get($scope,"syntax.Description"),
                    SyntaxForm: _.get($scope,"syntax.SyntaxForm"),
                };
                $syntaxSvc.createSyntax(syntax).then(function (items) {
                    if(_.get(items,"success")){
                        toastr.success("Cú pháp đã được thêm mới thành công","Success");
                        formLoad();
                    }else{
                        toastr.error("Đã có lỗi xảy ra, vui lòng liên hệ administrator để được hỗ trợ","ERROR 404");
                    }
                });
            }
            $uibModalInstance.close();
        }

    }
})();
