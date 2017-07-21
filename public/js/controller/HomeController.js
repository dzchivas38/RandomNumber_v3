/**
 * Created by Dev-1 on 21/07/2017.
 */
(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('HomeController', HomeController);

    HomeController.$inject = ['$scope'];

    function HomeController($scope) {
        $scope.title = 'HomeController';
        formLoad();
        function formLoad() {

        };
        $(function () {
            $('.txtDateTime').datetimepicker({
                dayOfWeekStart: 1,
                lang: 'vi',
                startDate: '2014/10/10',
                format: 'd/m/Y',
                dateonly: false,
                showHour: false,
                closeOnDateSelect: false,
                showMinute: false,
                timepicker: false,
                onChangeDateTime: function(dp, $input) {
                }
            });
        });
    }
})();
