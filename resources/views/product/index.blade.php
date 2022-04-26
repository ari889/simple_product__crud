@extends('layouts.app')

@section('title')
    {{ $page_title }}
@endsection

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Applications</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $page_title }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <h5 class="card-title"><i class="{{ $page_icon }} text-primary"></i> {{ $page_title }}</h5>
                <button type="button" class="btn btn-primary btn-sm" onclick="showFormModal('Add new product', 'Save')">
                    <i class="fas fa-plus-square"></i> Add New
                </button>
            </div>
            <form id="form-filter">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="title" class="mb-2">Product Title</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Enter subcategory title">
                    </div>
                    <x-form.selectbox labelName="Subcategory" name="subcategory_id"
                    col="col-md-3 mb-3" class="selectpicker">
                        @if(!$data['subcategories']->isEmpty())
                            @foreach ($data['subcategories'] as $subcategory)
                                <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                            @endforeach
                        @endif
                    </x-form.selectbox>
                    <div class="col-md-3 mb-3">
                        <label for="min" class="mb-2">Minimum Price</label>
                        <input type="text" name="min" id="min" class="form-control" placeholder="Enter minimum Price">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="max" class="mb-2">Maximum Price</label>
                        <input type="text" name="max" id="max" class="form-control" placeholder="Enter maximum price">
                    </div>
                    <div class="col-md-3 pt-24">
                        <button type="button" class="btn btn-danger btn-sm" id="btn-reset" data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Data"><i class="fas fa-redo-alt"></i></button>
                        <button type="button" class="btn btn-primary btn-sm me-2" id="btn-filter" data-bs-toggle="tooltip" data-bs-placement="top" title="Filter Data"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>

            <table id="dataTable" class="table table-stripped table-bordered table-hover">
                <thead class="bg-primary">
                    <tr>
                        <th>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="select_all" onchange="select_all()">
                                <label for="" class="custom-control-label" id="select_all"></label>
                            </div>
                        </th>
                        <th>SL</th>
                        <th>Thumbnail</th>
                        <th>Subcategory</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- menu add/edit modal start -->
@include('product.modal')
<!-- menu add/edit modal end -->
@endsection

@push('scripts')
<script src="https://cdn.tiny.cloud/1/xz6x9xqkgx3tatz9yh8d156k8cbrzyma87e3b159hpeinwta/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="js/spartan-multi-image-picker-min.js"></script>
    <script>
        $(document).ready(function(){
            var table;
            table = $('#dataTable').DataTable({
                "processing" : true, // control processing indicator
                "serverSide" : true, // serverside processing
                "order" : [], // initial no order
                "responsive" : true, // responsive true
                "bInfo" : true, // to show total number of data
                "bFilter" : false, // hide search box
                "lengthMenu" : [
                    [5,10,15,25,50,100,1000,10000,-1],
                    [5,10,15,25,50,100,1000,10000,"All"],
                ],
                "pageLength" : 25, // per page data,
                "language" : {
                    processing : '<i class="fas fa-spinner fa-spin fa-3x fa-fw text-primary"></i>',
                    emptyTable : '<strong class="text-danger">No data found</strong>',
                    infoEmpty : '',
                    zeroRecords : '<strong class="text-danger">No data found</strong>'
                },
                "ajax" : {
                    "url" : "{{ route('product.datatable.data') }}",
                    "type" : "POST",
                    "data" : function(data){
                        data.title          = $('#form-filter #title').val();
                        data.subcategory_id = $('#form-filter #subcategory_id').val();
                        data.min = $('#form-filter #min').val();
                        data.max = $('#form-filter #max').val();
                        data._token         = _token;
                    }
                },
                "columnDefs" : [
                    {
                        "targets" : [0,2,6],
                        "orderable" : false,
                        "className" : "text-center"
                    },
                    {
                        "targets" : [1,3,4],
                        "className" : "text-center"
                    },
                    {
                        "targets" : [5],
                        "className" : "text-right"
                    },
                ],
                "dom" : "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6' <'float-right'B>>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'<'float-right'p>>>",
                "buttons" : [
                    {
                        "extend" : "colvis",
                        "className" : "btn btn-secondary btn-sm text-white",
                        "text" : "Column"
                    },
                    {
                        "extend" : "print",
                        "text" : "Print",
                        "className" : "btn btn-secondary btn-sm text-white float-end",
                        "title" : "Subcategory List",
                        "orientation" : "landscape",
                        "pageSize" : "A4",
                        "exportOptions" : {
                            columns : function(index, data, node){
                                return table.column(index).visible();
                            }
                        },
                        customize : function(win){
                            $(win.document.body).addClass('bg-white');
                        }
                    },
                    {
                        "extend" : "csv",
                        "text" : "CSV",
                        "className" : "btn btn-secondary btn-sm text-white",
                        "title" : "Subcategory List",
                        "filename" : "product-list",
                        "exportOptions" : {
                            columns : function(index, data, node){
                                return table.column(index).visible();
                            }
                        },
                    },
                    {
                        "extend" : "excel",
                        "text" : "Excel",
                        "className" : "btn btn-secondary btn-sm text-white",
                        "title" : "Subcategory List",
                        "filename" : "product-list",
                        "exportOptions" : {
                            columns : function(index, data, node){
                                return table.column(index).visible();
                            }
                        },
                    },
                    {
                        "extend" : "pdf",
                        "text" : "PDF",
                        "className" : "btn btn-secondary btn-sm text-white",
                        "title" : "Subcategory List",
                        "filename" : "product-list",
                        "orientation" : "landscape",
                        "exportOptions" : {
                            columns : [1,3,4,5]
                        },
                    },
                    {
                        "className" : "btn btn-danger btn-sm delete_btn d-none text-white",
                        "text" : "Delete",
                        action: function(e, dt, node, config){
                            multi_delete();
                        }
                    }
                ]
            });
            
            // if user search
            $('#btn-filter').click(function(){
                table.ajax.reload();
            });
    
            // if user reset
            $('#btn-reset').click(function(){
                $('#form-filter')[0].reset();
                table.ajax.reload();
            });
    
            // if user add new menu
            $(document).on('click', '#save-btn', function(){
                let form = document.getElementById('store_or_update_form');
                let formData = new FormData(form);
                let url = "{{ route('product.store.or.update') }}";
                let id = $('#update_id').val();
                let method;
                if(id){
                    method = 'update';
                }else{
                    method = 'add';
                }
                store_or_update_data(table, method, url, formData);
            });
    
            // edit menu data
             $(document).on('click', '.edit_data', function(e){
                e.preventDefault();
                let id = $(this).data('id');
                $('#store_or_update_form')[0].reset();
                $('#store_or_update_form #update_id').val('');
                $('#store_or_update_form').find('.is-invalid').removeClass('is-invalid');
                $('#store_or_update_form').find('.error').remove();
                $('#store_or_update_form .selectpicker').selectpicker('refresh');
                $('#store_or_update_form table tbody').find('tr:gt(0)').remove();
                if(id){
                    $.ajax({
                        url : "{{ route('product.edit') }}",
                        type : "POST",
                        data : {
                            id : id,
                            _token : _token
                        },
                        dataType : "JSON",
                        success: function(data){
                            $('#store_or_update_form #update_id').val(data.data.id);
                            $('#store_or_update_form #subcategory_id').val(data.data.subcategory_id);
                            $('#store_or_update_form #title').val(data.data.title);
                            $('#store_or_update_form #description').val(data.data.description);
                            tinyMCE.get('description').setContent(data.data.description);
                            $('#store_or_update_form #price').val(data.data.price);
                            $('#store_or_update_form #old_image').val(data.data.thumbnail);
                            $('#store_or_update_form .selectpicker').selectpicker('refresh');
                            if(data.data.thumbnail){
                                var image = "{{ asset('storage/'.PRODUCT_IMAGE_PATH)}}/"+data.data.thumbnail;
                                $('#store_or_update_form #image img.spartan_image_placeholder').css('display','none');
                                $('#store_or_update_form #image .spartan_remove_row').css('display','none');
                                $('#store_or_update_form #image .img_').css('display','block');
                                $('#store_or_update_form #image .img_').attr('src',image);
                            }else{
                                $('#store_or_update_form #image img.spartan_image_placeholder').css('display','block');
                                $('#store_or_update_form #image .spartan_remove_row').css('display','none');
                                $('#store_or_update_form #image .img_').css('display','none');
                                $('#store_or_update_form #image .img_').attr('src','');
                            }
    
                            myModal = new bootstrap.Modal(document.getElementById('store_or_update_modal'), {
                                keyboard: false,
                                backdrop: 'static'
                            });
    
                            myModal.show();
    
                            $("#store_or_update_modal .modal-title").html('<i class="fas fa-edit"></i> '+data.data.title);
                            $("#store_or_update_modal #save-btn").text("Update");
                        }
                    });
                }
             });

            //  delete data
            $(document).on('click', '.delete_data', function(e){
                e.preventDefault();
                let id = $(this).data('id');
                let name = $(this).data('name');
                let row = table.row($(this).parent('tr'));
                let url = "{{ route('product.delete') }}";
                delete_data(id, url, table, row, name);
            });

            // dropify image picker
            $('#image').spartanMultiImagePicker({
                fieldName: 'image',
                maxCount: 1,
                rowHeight: '200px',
                groupClassName: 'col-md-12 com-sm-12 com-xs-12',
                maxFileSize: '',
                dropFileLabel: 'Drop Here',
                allowExt: 'png|jpg|jpeg',
                onExtensionErr: function(index, file){
                    Swal.fire({icon:'error',title:'Oops...',text: 'Only png,jpg,jpeg file format allowed!'});
                }
            });

            $('input[name="image"]').prop('required',true);

            $('.remove-files').on('click', function(){
                $(this).parents('.col-md-12').remove();
            });
            

            // bulk delete menu
            function multi_delete(){
                let ids = [];
                let rows;
                $('.select_data:checked').each(function(){
                    ids.push($(this).val());
                    rows = table.rows($('.select_data:checked').parents('tr'));
                });
                if(ids.length == 0){
                    Swal.fire({
                        type : 'error',
                        title : 'Error',
                        text : "Please checked at least one row if the table!",
                        icon : "warning"
                    });
                }else{
                    let url = "{{ route('product.bulk.delete') }}";
                    bulk_delete(ids, url, table, rows);
                }
            }
        });

        // generate category slug
        function url_generator(input_value, output_id){
            var value = input_value.toLowerCase().trim();
            var str = value.replace(/ +(?= )/g, '');
            var name = str.split(' ').join('-');
            $('#'+output_id).val(name);
        }

        // tinymce editor for description
        tinymce.init({
            selector: '#description',
            plugins: 'advlist autolink lists link image charmap preview anchor pagebreak',
            toolbar_mode: 'floating',
            setup: function(editor){
                editor.on('change', function(){
                    tinyMCE.triggerSave();
                })
            }
        });
    </script>
@endpush
