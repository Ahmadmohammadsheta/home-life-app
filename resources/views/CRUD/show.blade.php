@extends('layouts.master')


@section('title')
    <span class="text-muted mt-1 tx-30 mr-2 mb-0">{{ "Show ".ucfirst($tableName) }}</span>
@stop

@section('css')    <!---Internal  Prism css-->
<link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
<!---Internal Input tags css-->
<link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
<!--- Custom-scroll -->
<link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection


@section('page-header')
{{ __(ucfirst($tableName)) }}
@endsection

@section('content')
				<!-- row -->
				<div class="row">
                    <div class="col-xl-12">
                        <!-- div -->
                        <div class="card mg-b-20" id="tabs-style2">
                            <div class="card-body">
                                <div class="text-wrap">
                                    <div class="example">
                                        <div class="panel panel-primary tabs-style-2">
                                            <div class=" tab-menu-heading">
                                                <div class="tabs-menu1">
                                                    <!-- Tabs -->
                                                    <ul class="nav panel-tabs main-nav-line">
                                                        <li><a href="#tab4" class="nav-link active" data-toggle="tab">{{ __('General Information') }}</a></li>
                                                        <li><a href="#tab5" class="nav-link" data-toggle="tab">{{ __('Some') }}</a></li>
                                                        <li><a href="#tab6" class="nav-link" data-toggle="tab">{{ __('Nom') }}</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="tab4">
                                                        <div class="card">
                                                            {{-- <div class="card-header">{{ dd($$modelObjectName) }}</div> --}}
                                                            <hr>
                                                            <div class="card-body">
                                                                @foreach ($filterColumnNames as $filterColumnName)
                                                                @if ($filterColumnName !== "image")
                                                                <td class="border-bottom-0 text-center"><p>{{ "The $filterColumnName" }} <strong class="text-danger">{{ (json_encode($$modelObjectName[$filterColumnName])) }}</strong></p></td>

                                                                @endif
                                                                @endforeach

                                                                @foreach ($filterColumnNames as $filterColumnName)
                                                                @if ($filterColumnName == "image")
                                                                <div class="border-bottom-0 text-center" style="width: 240px; hieght:180px">
                                                                    <a href="{{ asset("attachments/categories/".$$modelObjectName[$filterColumnName]) }}" target="_blank">
                                                                        <img src="{{ (asset("attachments/categories/".$$modelObjectName[$filterColumnName])) }}" alt="My Image">
                                                                    </a>
                                                                </div>
                                                                @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane" id="tab5">
                                                        <div class="table-responsive mt-15">


                                                        </div>
                                                    </div>


                                                    <div class="tab-pane" id="tab6">
                                                        <div class="card card-statistics">


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- /div -->
                    </div>
				</div>
				<!-- row closed -->
@endsection


@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- Internal Input tags js-->
    <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
    <!--- Tabs JS-->
    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>

    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_file = button.data('id_file')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)

            modal.find('.modal-body #id_file').val(id_file);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })

    </script>

    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

    </script>

@endsection
