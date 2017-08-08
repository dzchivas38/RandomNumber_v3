<!DOCTYPE html>
<html>
    <head>
        <title>Random Number Project</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

         <script src="{!! url('statics/angular/angular.min.js') !!}"></script>
         <script src="{!! url('statics/jquery/dist/jquery.min.js') !!}"></script>

        <script src="{!! url('statics/jquery/dist/jquery.datetimepicker.js') !!}"></script>

         <script src="{!! url('statics/bootstrap/dist/js/bootstrap.min.js') !!}"></script>
         <script src="{!! url('statics/angular-ui-router/release/angular-ui-router.min.js') !!}"></script>
         <script src="{!! url('statics/angular/angular-block-ui.min.js') !!}"></script>
         <script src="{!! url('statics/angular/angular-toastr.tpls.js') !!}"></script>
         <script src="{!! url('statics/angular-ui-bootstrap/dist/ui-bootstrap-tpls.js') !!}"></script>
         <script src="{!! url('statics/lodash/lodash.min.js') !!}"></script>
         <script src="{!! url('statics/magicsuggest/magicsuggest-min.js') !!}"></script>
         <script src="{!! url('statics/moment/moment.min.js') !!}"></script>

        <link href="{!! url('css/textangular/dist/textAngular.css') !!}" rel="stylesheet " type="text/css " />
         <script src="{!! url('statics/textangular/dist/textAngular-rangy.min.js') !!}"></script>
         <script src="{!! url('statics/textangular/dist/textAngular-sanitize.min.js') !!}"></script>
         <script src="{!! url('statics/textangular/dist/textAngular.min.js') !!}"></script>

        <link href="{!! url('css/bootstrap/bootstrap.min.css') !!}" rel="stylesheet " type="text/css " />
        <link href="{!! url('css/font-awesome/css/font-awesome.min.css') !!}" rel="stylesheet " type="text/css " />
        <link href="{!! url('css/simple-line-icon/simple-line-icons.css') !!}" rel="stylesheet " type="text/css " />
        <link href="{!! url('statics/magicsuggest/magicsuggest-min.css') !!}" rel="stylesheet " type="text/css " />

        <link href="{!! url('statics/jquery/dist/jquery.datetimepicker.css') !!}" rel="stylesheet " type="text/css " />
        <link href="{!! url('statics/angular/angular-block-ui.min.css') !!}" rel="stylesheet " type="text/css " />
        <link href="{!! url('statics/angular/angular-toastr.css') !!}" rel="stylesheet " type="text/css " />
        <link href="{!! url('custom.css') !!}" rel="stylesheet " type="text/css " />

        <script src="{!! url('app.js') !!}"></script>
        {{---------------------------MODAL-------------------------------}}
        <script src="{!! url('template/Modal/playerFormController.js') !!}"></script>
        <script src="{!! url('template/Modal/actionTypeFormController.js') !!}"></script>
        {{---------------------------ENDMODAL-----------------------------}}

        {{--------------------------SERVICES------------------------------}}
        <script type="text/javascript" src="{!! url('js/services/PlayerService.js') !!}"></script>
        <script type="text/javascript" src="{!! url('js/services/HomeService.js') !!}"></script>
        {{--------------------------ENDSERVICES---------------------------}}
         <!--------------------------CONTROLLER-------------------------- -->

        <script src="{!! url('js/controller/PlayerListController.js') !!}"></script>
        <script src="{!! url('js/controller/HomeController.js') !!}"></script>
        <script src="{!! url('js/controller/SyntaxListController.js') !!}"></script>
        <script src="{!! url('js/controller/ActionTypeListController.js') !!}"></script>
        <script src="{!! url('js/controller/CalculatorController.js') !!}"></script>
        <!-- ------------------------ENDCONTROLLER----------------------- -->


    </head>
    <body>
        <div id="wrapper" ng-app="randomNumberApp">
            <!-- NAVIGATION -->
            <div ng-include="'template/Header/Header.html'"></div>
            <!-- NAVIGATION -->

            <!-- Sidebar -->
            <div ng-include="'template/Sidebar/Sidebar.html'"></div>
            <!-- Sidebar -->
            <div id="page-content-wrapper">
                <div class="page-content">
                    <div class="container-fluid">
                        <div ui-view></div>
                    </div>
                </div>
            </div>
             <!-- FOOTER -->
            <div ng-include="'template/Footer/Footer.html'"></div>
            <!-- FOOTER -->
        </div>
    </body>
</html>
