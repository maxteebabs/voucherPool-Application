<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Voucher Pool</title>

        <!-- Fonts -->
        <!-- <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css"> -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" style="text/css" />
        <link rel="stylesheet" href="{{ asset('css/main.css') }}" style="text/css" />
        <!-- font awesome -->
        <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
        <!-- select2input -->
        <link rel="stylesheet" style="text/css" href="{{asset('plugin/select2input/css/select2.min.css') }}">
        <link rel="stylesheet" style="text/css" href="{{asset('plugin/datepicker/jquery_datetimepicker.css') }}">
        <!-- toastr -->
        <link rel="stylesheet" href="{!! asset('plugin/toastr/toastr.min.css') !!}" type="text/css">
        <!-- datatable -->
        <link rel="stylesheet" href="{{ asset('plugin/datatables/jquery.dataTables.css') }}">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }     
            .stat-block {
                text-align: center;
                vertical-align: middle;
            }
        </style>
    </head>
    <body>
        <div class="container" id="app">  
            <voucher></voucher>         
        </div>
    
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugin/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('plugin/select2input/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugin/datepicker/jquery_datetimepicker.min.js') }}"></script>
    <script src="{{ asset('plugin/datatables/jquery.dataTables.js') }}"></script>
    <script>
        $(document).ready(function() { 
            $("#e1").select2({
                placeholder: "Select",
                allowClear: true,
                minimumInputLength: 1,
                tags:[],
                ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
                    url: "/special/offers/list",
                    dataType: 'json',
                    quietMillis: 250,
                    data: function (term, page) {
                        return {
                            q: term, // search term
                        };
                    },
                    results: function (data, page) { 
                        console.log(data);
                        return { results: data.items };
                    },
                    cache: true
                }
            }); 
        });

        setTimeout(function() {
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        },2000)

        
    </script>
    </body>
</html>
