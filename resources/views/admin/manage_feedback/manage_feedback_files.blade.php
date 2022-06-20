<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.template.head', ["title"=>"AdminFeedback Files"])
    <link rel="stylesheet" href="{{url('')}}/layout/plugins/ekko-lightbox/ekko-lightbox.css">
    <style>
        .height {
            max-height: 200px;
            height: 200px;
            width: 100%;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">


        @include('admin.template.nav')

        @include('admin.template.aside')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">Feedback Files</h1>
                        </div>
                    </div>
                </div>
            </div>

         
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4 class="card-title">Users Files</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        @foreach($images as $key => $row)
                                        <div class="col-sm-2">
                                            <!-- <a href="" data-toggle="lightbox" data-title="On-Page Task 1" data-gallery="gallery">
                                                <img src="" class="img-fluid mb-2" alt="Seo Task" />
                                            </a> -->

                                            @php
                                            $ext = '';
                                                if(!empty($row->file)){
                                                $ext = pathinfo($row->file, PATHINFO_EXTENSION);

                                                }
                                                @endphp

                                                @if($ext == 'png' || $ext == 'jpeg' || $ext == 'jpg')
                                                <a href="{{url('')}}/admin/manage/users/feedback/{{$row->file}}" data-toggle="lightbox" data-title="User Assign Task" data-gallery="gallery">
                                                <img src="{{url('')}}/admin/manage/users/feedback/{{$row->file}}" class="img-fluid mb-2 height" alt="Seo Task" />
                                            </a>

                                            <div class="text-center">
                                                <a href="{{url('')}}/admin/manage/users/feedback/{{$row->file}}" target="_blank">
                                                    View File
                                                </a>
                                            </div>
                                                @else
                                                <a href="{{url('')}}/admin/manage/users/feedback/{{$row->file}}" data-toggle="lightbox" data-title="User Assign Task" data-gallery="gallery">
                                                
                                            </a>

                                            <div class="text-center">
                                                <a href="{{url('')}}/admin/manage/users/feedback/{{$row->file}}" target="_blank" download>
                                                <i class="fas fa-file-download"></i> Download File
                                                </a>
                                                @endif

                                           
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- /.container-fluid -->
            </section>



        </div>
        <!-- /.content-wrapper -->

        @include('admin.template.footer')


    </div>
    <!-- ./wrapper -->

    @include('admin.template.scripts')
    <script src="{{url('')}}/layout/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>

    <script>
        $(function() {
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true,
                    // leftArrow: `<i class='fas fa-chevron-circle-left'></i>`,
                    // rightArrow: `<i class='fas fa-chevron-circle-right'></i>`
                });
            });

            // $('.filter-container').filterizr({
            //   gutterPixels: 3
            // });
            // $('.btn[data-filter]').on('click', function() {
            //   $('.btn[data-filter]').removeClass('active');
            //   $(this).addClass('active');
            // });
        });
    </script>