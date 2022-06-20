<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"SEO Work Report Gallery"])

  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="{{url('')}}/layout/plugins/ekko-lightbox/ekko-lightbox.css">
</head>

<body class="hold-transition sidebar-mini">
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
              <h1 class="m-0">SEO Work Report Gallery</h1>
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
                  <h4 class="card-title">Gallery</h4>
                </div>
                <div class="card-body">
                  <div class="row">

                    @foreach($blade_data as $key => $row)
                    <div class="col-sm-2">
                      <!-- <a href="{{url('')}}/storage/{{$row->image}}" data-toggle="lightbox" data-title="On-Page Task {{$key+1}}" data-gallery="gallery">
                        <img src="{{url('')}}/storage/{{$row->image}}" class="img-fluid mb-2" alt="Seo Task" />
                      </a> -->
                      <a href="{{url('')}}/admin/work-report/images/render/{{$row->image}}" data-toggle="lightbox" data-title="On-Page Task {{$key+1}}" data-gallery="gallery">
                        <img src="{{url('')}}/admin/work-report/images/render/{{$row->image}}" class="img-fluid mb-2" alt="Seo Task" />
                      </a>
                      <div class="text-center">
                        <a href="{{url('')}}/admin/work-report/images/render/{{$row->image}}" target="_black">
                          View Full Image
                        </a>
                      </div>
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

  <!-- Ekko Lightbox -->
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
</body>

</html>