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
        $scope.data={};
        $scope.isInsert = false;
        $scope.search = function () {
            $scope.isInsert = false;
            $scope.searchDate = $('#searchDate').val();
            formLoad($scope.searchDate);

        };
        formLoad();
        function formLoad(keySearch) {
            var now = moment().format('YYYY-MM-DD');
            var result = [];
            keySearch = (keySearch) ? keySearch : now;

            $homeSvc.getResultScheduce(keySearch).then(function (item) {
                if(_.get(item,"length") > 0){
                    _.set($scope,"data",item[0]);
                    result = $scope.data.Description.split('\n');
                    _.pullAt(result, [0]);
                    var count = 0;
                    var temp = _.map(result,function (num) {
                        var value = num.substring(num.indexOf(':') + 2);
                        var key = "";
                        var colspan=0;
                        var style = {};
                        switch (count) {
                            case 0:
                                key = "Giải đặc biệt";
                                colspan = 6;
                                style = {"color": "red","font-weight": "bold"};
                                break;
                            case 1:
                                key = "Giải nhất";
                                colspan = 6;
                                style = '';
                                break;
                            case 2:
                                key = "Giải nhì";
                                colspan = 3;
                                style = '';
                                break;
                            case 3:
                                key = "Giải ba";
                                colspan = 1;
                                style = '';
                                break;
                            case 4:
                                key = "Giải tư";
                                colspan = 1;
                                style = '';
                                break;
                            case 5:
                                key = "Giải năm";
                                colspan = 1;
                                style = '';
                                break;
                            case 6:
                                key = "Giải sáu";
                                colspan = 2;
                                style = '';
                                break;
                            case 7:
                                key = "Giải bảy";
                                colspan = 1;
                                style = '';
                                break;
                        }
                        count++;
                        return {key : key, value :_.split(value, ' - '), colspan : colspan, style : style}
                    });
                    _.set($scope,"data.Description",temp);
                }else {
                    //to do
                    _.set($scope,"data.Description",false);
                }
            });
            $(function () {
                $('.txtDateTime').datetimepicker({
                    dayOfWeekStart: 1,
                    lang: 'vi',
                    startDate: '2014-10-10',
                    format: 'Y-m-d',
                    dateonly: false,
                    showHour: false,
                    closeOnDateSelect: true,
                    showMinute: false,
                    timepicker: false,
                    onChangeDateTime: function(dp, $input) {
                    }
                });
            });
        };
        $scope.insertStart = function (){
            $scope.isInsert = !$scope.isInsert;
        };
        $scope.insert = function (){
            var data = {};
            var template = "\n" +
                "ĐB: "+$scope.val_db+"\n" +
                "1: "+$scope.val_o+"\n" +
                "2: "+$scope.val_two_a+" - "+$scope.val_two_b+"\n" +
                "3: "+$scope.val_three_a+" - "+$scope.val_three_b+" - "+$scope.val_three_c+" - "+$scope.val_three_d+" - "+$scope.val_three_e+" - "+$scope.val_three_f+"\n" +
                "4: "+$scope.val_f_a+" - "+$scope.val_f_b+" - "+$scope.val_f_c+" - "+$scope.val_f_d+"\n" +
                "5: "+$scope.val_fi_a+" - "+$scope.val_fi_b+" - "+$scope.val_fi_c+" - "+$scope.val_fi_d+" - "+$scope.val_fi_e+" - "+$scope.val_fi_f+"\n" +
                "6: "+$scope.val_s_a+" - "+$scope.val_s_b+" - "+$scope.val_s_c+"\n" +
                "7: "+$scope.val_sev_a+" - "+$scope.val_sev_b+" - "+$scope.val_sev_c+" - "+$scope.val_sev_d+"";
            var searchDate = $('#searchDate').val();
            if (!searchDate){
                toastr.warning("Chọn ngày để phập kết quả","Cảnh báo");
                return;
            }else{
                data.PubDate = searchDate;
                data.Title = "KẾT QUẢ XỔ SỐ MIỀN BẮC NGÀY " + searchDate;
            }
            data.Description = _.clone(template);
            data.isDelete = false;
            $homeSvc.createKq(data).then(function (item) {
               if (_.get(item,"success")){
                   toastr.success("Thêm mới dữ liệu thành công","Success");
                   formLoad(null);
               }else {
                   toastr.error("ERROR 404","ERROR");
                   return;
               }
            });
        }
    }
})();
