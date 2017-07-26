/**
 * Created by DungNV44 on 7/26/2017.
 */
(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('CalculatorController', CalculatorCtrl);

    CalculatorCtrl.$inject = ['$scope'];

    function CalculatorCtrl($scope) {
        $scope.title = 'CalculatorController';
        formLoad();
        function formLoad() {

        };
        var vm={};
        $(function () {
            $('.txtDateTime').datetimepicker({
                dayOfWeekStart: 1,
                lang: 'vi',
                startDate: '2014/10/10',
                format: 'd/m/Y',
                dateonly: false,
                showHour: false,
                closeOnDateSelect: true,
                showMinute: false,
                timepicker: false,
                onChangeDateTime: function(dp, $input) {
                }
            });
            var data = [{Id:1,Name:'Dũng'},{Id:2,Name:'Khánh'}]
            vm.msCaPlayer = $('#ms-ca-player').magicSuggest({
                resultAsString: true,
                maxDropHeight: 145,
                placeholder: 'Chọn khách hàng',
                valueField: 'Id',
                editable: false,
                displayField: 'Name',
                expandOnFocus: true,
                data: data
            });
            $(vm.msCaPlayer).on('selectionchange', function () {
                var selection = JSON.stringify(this.getSelection());
                var temp = this.getSelection();
                console.log(selection);
                console.log(temp);
            });
        });
    }
})();