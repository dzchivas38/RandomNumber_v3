/**
 * Created by DungNV44 on 7/26/2017.
 */
(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('CalculatorController', CalculatorCtrl);

    CalculatorCtrl.$inject = ['$scope','CalculatorSvc','PlayerSvc','SyntaxSvc','toastr','blockUI'];

    function CalculatorCtrl($scope,$CalculatorSvc,$playerSvc,$syntaxSvc,toastr,blockUI) {
        $scope.title = 'CalculatorController';
        $scope.playerList = [];
        $scope.syntaxList = [];
        $scope.kqListItem = [];
        $scope.kqListItemDetail = [];
        $scope.htmlcontent = "";
        $scope.request = {
            msg:"",
            pubDate:"",
            player:{}
        };
        $scope.cashOutByPlayerId = [];
        var htmlCodeHeader = "<span style='color: red;text-decoration: line-through;'>";
        var htmlCodeEnd = "</span>";
        formLoad();
        function formLoad() {
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
                        _.set($scope,"request.pubDate",moment(dp).format('YYYY-MM-DD'));
                        _.set($scope,"pubDate",moment(dp).format('DD/MM/YYYY'));
                        console.log($scope.request.pubDate);
                    }
                });
                $scope.request.pubDate = moment().format('YYYY-MM-DD');
                $scope.pubDate = moment().format('DD/MM/YYYY');
                $playerSvc.getAll().then(function (items) {
                    _.set($scope,"playerList",items);
                    vm.msCaPlayer = $('#ms-ca-player').magicSuggest({
                        data: $scope.playerList,
                        allowFreeEntries: true,
                        expandOnFocus: true,
                        editable: false,
                        maxDropHeight: 145,
                        placeholder: 'Chọn khách hàng',
                        valueField: 'Id',
                        displayField: 'Name',
                        maxSelection: 1
                    });
                    $(vm.msCaPlayer).on('selectionchange', function () {
                        var temp = this.getSelection();
                        _.set($scope,"request.player",_.clone(temp[0]));
                        $playerSvc.getCashOutByPlayerId(_.get($scope,"request.player.Id")).then(function (item) {
                            _.set($scope,"cashOutByPlayerId",item);
                        });
                    });
                });
            });
            $syntaxSvc.getAll().then(function (items) {
               _.set($scope,"syntaxList",items);
            });
        };
        var vm={};
        // truyền vào: msg,pubdate,customer
        $scope.process = function () {
            $scope.kqDetailTmp = null;
            if (!_.get($scope,"request.player.Id")){
                toastr.warning("Vui lòng nhập khách hàng !","Cảnh báo");
                return;
            }
            $scope.htmlcontent = deCodeHtmlContent($scope.htmlcontent);
            _.set($scope,"request.msg",_.clone($scope.htmlcontent));
            var checked = validateMsg();
            if (checked){
                $CalculatorSvc.process($scope.request)
                    .then(function (item) {
                        if(_.get(item,"status") === false){
                            if (item.msg){
                                toastr.error(item.msg, 'Cảnh báo');
                            }else {
                                toastr.error('Tin nhắn chưa đúng cú pháp!', 'Cảnh báo');
                            }
                            $scope.htmlcontent = endCodeHtmlContent($scope.htmlcontent,_.get(item,"issueHightlightIndex"));
                        }else {
                            var groupByActionType = _.groupBy(item.data,function (obj) {
                                return _.get(obj,"action_type");
                            });
                            groupByActionType = _.mapValues(groupByActionType,function (obj) {
                               var kq = _.sumBy(obj,function (o) {
                                   return o.kq_cc;
                               });
                                obj.kq = kq;
                               var sum = _.sumBy(obj,function (o) {
                                  return o.sum;
                               });
                                obj.sum = sum;
                                var bingo = _.sumBy(obj,function (o) {
                                    return o.bingo;
                                });
                                obj.bingo = bingo;
                               return obj;
                            });
                            var toArr = _.toArray(groupByActionType);
                            var kqcc = _.sumBy(toArr,function(o){return o.kq});
                            var pushItem = {
                                player: _.get($scope,"request.player"),
                                kqcc : kqcc,
                                detail:toArr
                            };
                            $scope.kqcc_view = _.clone(kqcc);
                            $scope.kqDetailTmp = _.map(item.data,function (obj) {
                               obj.str_so_trung = obj.so_trung + "";
                               obj.str_so_danh = obj.so_danh + "";
                               obj.allValue = _.get(obj,"so_danh.length")*_.get(obj,"value");
                               var highlight =  _.map(obj.so_danh,function (so_danh) {
                                   var _return = {
                                       so_danh: so_danh
                                   };
                                  var check = _.some(obj.so_trung,function (so_trung) {
                                     return so_danh == so_trung;
                                  });
                                  if(check){
                                      _return.highlight = true;
                                      return _return;
                                  }else {
                                      _return.highlight = false;
                                      return _return;
                                  }
                               });
                               obj.highlight = highlight;
                               return obj;
                            });
                            $scope.kqListItem.push(pushItem);
                            $scope.kqListItemDetail.push(groupByActionType);
                        }
                    });
            }
        };
        function validateMsg() {
            var htmlcontentClone = ($scope.htmlcontent) ? _.clone($scope.htmlcontent) :"";
            if (htmlcontentClone.length >0){
                htmlcontentClone = verifyMsg(htmlcontentClone,$scope.syntaxList);
                htmlcontentClone = highLightError(htmlcontentClone,$scope.syntaxList);
                //htmlcontentClone = removeFirstChar(htmlcontentClone,$scope.syntaxList);
                htmlcontentClone = htmlcontentClone.replaceAll("×","x",true);
                htmlcontentClone = htmlcontentClone.replaceAll("X","x",true);
                htmlcontentClone = htmlcontentClone.replaceAll("xxx","x",true);
                htmlcontentClone = htmlcontentClone.replaceAll("xx","x",true);
                //2 dấu X liền nhau => 1 dấu x
                //Chỉ còn 1 dấu X trong 1 đoạn
                _.set($scope,"htmlcontent",htmlcontentClone);
                return true;
            }else{
                toastr.warning("Vui lòng nhập tin nhắn cần tính","Cảnh báo!");
                return false;
            }
        }
        function verifyMsg(str,syntaxList) {
            str = (str) ? str : "";
            if (str.length >0){
                var arrReplace = [];
                var charList = str.split(" ");
                var mapList = _.map(charList,function (item) {
                   var _re = item.split(".");
                   return _re;
                });
                for (var i=0;i<mapList.length;i++){
                    _.forEach(mapList[i],function (item) {
                        var checked = _.some(syntaxList,function (obj) {
                            return _.toLower(_.get(obj,"Name")) == _.toLower(item);
                        });
                        if (checked){
                            arrReplace.push(item);
                        }
                    });
                }
                if (arrReplace.length > 0){
                    _.forEach(arrReplace,function (item) {
                        var strOld = "."+item;
                        var strNew = " "+item;
                       str = str.replaceAll(strOld,strNew,true);
                    });
                }
            }
            return str;
        }
        function highLightError(str,syntaxList) {
            var htmlCodeHeader = "<span style='color: red;text-decoration: line-through;'>";
            var htmlCodeEnd = "</span>";
            str = (str) ? str : "";
            var charList = str.split(" ");
            var temp = [];
            for (var i=0;i<charList.length;i++){
                var checked = _.some(syntaxList,function (item) {
                    return _.toLower(_.get(item,"Name")) == _.toLower(charList[i]);
                });
                if (!checked){
                    temp.push(i);
                }else {
                    break;
                }
            }
            var  maplist = [];
            if (temp.length > 0){
                var len = temp.length;
                maplist = _.map(charList,function (item,value) {
                   if (value === 0 && temp[0] === 0){
                       return htmlCodeHeader + item + htmlCodeEnd;
                   }else {
                       if (value === 0){
                           return htmlCodeHeader + item;
                       }
                       if (value == temp[len - 1]){
                           return (item + htmlCodeEnd);
                       }else {
                           return item
                       }
                   }
                });
                return _.map(maplist).join(" ");
            }else {
                return str;
            }

        }
        function removeFirstChar(str,syntaxList) {
            str = (str) ? str : "";
            var charList = str.split(" ");
            var temp = [];
            for (var i=0;i<charList.length;i++){
                var checked = _.some(syntaxList,function (item) {
                                    return _.toLower(_.get(item,"Name")) == _.toLower(charList[i]);
                                });
                if (!checked){
                    temp.push(i);
                }else {
                    break;
                }
            }
            if (temp.length > 0){
                _.pullAt(charList,temp);
                toastr.warning("Những kí tự đầu tin nhắn sai cú pháp đã được remove!","Cảnh báo");
            }
            return _.map(charList).join(" ");
        }
        function endCodeHtmlContent(htmlcontent,items) {
            var htmlcontentClone = _.clone(htmlcontent);
            if (items.length > 0){
                if (htmlcontentClone.length > 0){
                    _.forEach(items,function (item) {
                        item = (item.length == 1 || item.length == 2) ?  " " + item + " " : item;
                        var newChar = htmlCodeHeader + item + htmlCodeEnd;
                        htmlcontentClone = htmlcontentClone.split(item).join(newChar);
                    });
                    return htmlcontentClone;
                }else {
                    return "";
                }
            }else {
                return htmlcontent;
            }
        }
        function deCodeHtmlContent(str)
        {
            str = (str) ? str :"";
            str = str.replaceAll("<br/>",' ',true);
            str = str.replaceAll("</p>",' ',true);
            if ((str===null) || (str===''))
                return false;
            else
                str = str.toString();
            return str.replace(/<[^>]*>/g, '');
        }
    }
})();