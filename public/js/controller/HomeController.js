/**
 * Created by Dev-1 on 21/07/2017.
 */
(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('HomeController', HomeController);

    HomeController.$inject = ['$scope','HomeSvc','$uibModal','toastr'];

    function HomeController($scope,$homeSvc,$uibModal,toastr) {
        $scope.title = 'HomeController';
        formLoad();
        function formLoad() {
            $homeSvc.getResultScheduce().then(function (item) {
               console.log(item);
               // var resultScheduce = _.map(item,function (r) {
               //     var descArr = _.split(r.description, '\n', _.get(r,"description.length"));
               //     r.description = _.clone(descArr);
               //     return r;
               // });
               // console.log(resultScheduce);
            });
        };
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
        });
    }
})();
