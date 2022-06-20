<!DOCTYPE html>
<html lang="en">

<head>
  @include('user_template.head', ["title"=>"Order Dashboard"])
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">


    @include('user_template.nav')


    @include('user_template.aside')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Year Order</h1>
            </div>
            <div class="col-sm-6 text-right">
              <form id="form-year-report">
                @csrf()
                <div class="form-row">
                  <div class="col-md-5">
                  </div>
                  <div class="col-md-3">
                    <label class="col-form-label">Select Year: </label>
                  </div>
                  <div class="col-md-3">
                    <select class="form-control" name="sales_year" id="sales_year" style="width: 100%;">
                      @for($i=1900; $i <= 2099; $i++) @if($i==date("Y")) <option value="{{$i}}" selected>{{$i}}</option>
                        @else
                        <option value="{{$i}}">{{$i}}</option>
                        @endif

                        @endfor
                    </select>
                  </div>
                  <div class="col-md-1 text-center">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-sync"></i></button>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>



      <div class="content">
        <div class="container-fluid">

          <div class="row">

            <div class="col-lg-6">

              <div class="card" id="sales-chart-card">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title text-bold"></h3>
                  </div>
                </div>
                <div class="card-body">
                  <div class="d-flex">
                    <p class="d-flex flex-column">
                      <span class="text-bold text-lg text-danger total-sales"></span>
                      <span>Total Sales</span>
                    </p>
                    <p class="ml-auto d-flex flex-column text-right"></p>
                  </div>
                  <!-- /.d-flex -->

                  <div class="position-relative mb-4" id="sales-chart-div"></div>

                  <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                      <i class="fas fa-square text-primary"></i> <span class="bottom-text"></span>
                    </span>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>


            <div class="col-lg-6">
              <div class="card" id="sales-line-chart-card">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title text-bold"></h3>
                  </div>
                </div>
                <div class="card-body">
                  <div class="d-flex">
                    <p class="d-flex flex-column">
                      <span class="text-bold text-lg text-danger total-sales"></span>
                      <span>Total Sales</span>
                    </p>
                    <p class="ml-auto d-flex flex-column text-right"></p>
                  </div>
                  <!-- /.d-flex -->

                  <div class="position-relative mb-4" id="sales-line-chart-div"></div>

                  <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                      <i class="fas fa-square text-primary"></i> <span class="bottom-text"></span>
                    </span>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>

          </div>
          <!-- /.row -->

          <div class="row mt-4">
            <div class="col-12">
              <div class="container-fluid">
                <div class="row mb-2">
                  <div class="col-sm-6">
                    <h2 class="m-0">Month Order</h2>
                  </div>
                  <div class="col-sm-6 text-right">
                    <form id="form-month-report">
                      @csrf()
                      <div class="form-row">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-3">
                          <label class="col-form-label">Select Month: </label>
                        </div>
                        <div class="col-md-5">
                          <div class="form-group">
                            <input value="{{date('Y-m')}}" type="month" name="sales_month" id="sales_month" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-1 text-center">
                          <button type="submit" class="btn btn-primary"><i class="fas fa-sync"></i></button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <!-- Month order Row -->
          <div class="row">

            <div class="col-lg-6">

              <div class="card" id="sales-chart-month-card">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title text-bold"></h3>
                  </div>
                </div>
                <div class="card-body">
                  <div class="d-flex">
                    <p class="d-flex flex-column">
                      <span class="text-bold text-lg text-danger total-sales"></span>
                      <span>Total Sales</span>
                    </p>
                    <p class="ml-auto d-flex flex-column text-right"></p>
                  </div>
                  <!-- /.d-flex -->

                  <div class="position-relative mb-4" id="sales-chart-month-div"></div>

                  <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                      <i class="fas fa-square text-primary"></i> <span class="bottom-text"></span>
                    </span>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>


            <div class="col-lg-6">
              <div class="card" id="sales-line-chart-month-card">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title text-bold"></h3>
                  </div>
                </div>
                <div class="card-body">
                  <div class="d-flex">
                    <p class="d-flex flex-column">
                      <span class="text-bold text-lg text-danger total-sales"></span>
                      <span>Total Sales</span>
                    </p>
                    <p class="ml-auto d-flex flex-column text-right"></p>
                  </div>
                  <!-- /.d-flex -->

                  <div class="position-relative mb-4" id="sales-line-chart-month-div"></div>

                  <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                      <i class="fas fa-square text-primary"></i> <span class="bottom-text"></span>
                    </span>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>

          </div>
          <!-- /.row -->


          <!-- user Month order Row -->
          <div class="row mt-4">
            <div class="col-12">
              <div class="container-fluid">
                <div class="row mb-2">
                  <div class="col-sm-6">
                    <h2 class="m-0">Month Sales by SEOs</h2>
                  </div>
                  <div class="col-sm-6 text-right">
                    <form id="form-month-user-report">
                      @csrf()
                      <div class="form-row">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-3">
                          <label class="col-form-label">Select Month: </label>
                        </div>
                        <div class="col-md-5">
                          <div class="form-group">
                            <input value="{{date('Y-m')}}" type="month" name="sales_month" id="sales_month" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-1 text-center">
                          <button type="submit" class="btn btn-primary"><i class="fas fa-sync"></i></button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- user Month order Row -->
          <div class="row">

            <div class="col-lg-12">

              <div class="card" id="sales-chart-month-user-card">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title text-bold"></h3>
                    <span class="float-right">
                      <strong>Note:</strong> Current month Performance is based up to current date.
                    </span>
                  </div>
                </div>
                <div class="card-body">
                  <div class="d-flex">
                    <p class="d-flex flex-column">
                      <span class="text-bold text-lg text-danger total-sales"></span>
                      <span>Total Sales</span>
                    </p>

                    <p class="col-4 ml-auto d-flex flex-column">

                      <span class="">
                        <i class="fas fa-square text-primary"></i>
                        <span class="">Excellent Performance [40+]</span>
                      </span>

                      <span class="">
                        <i class="fas fa-square text-success"></i>
                        <span class="">Good Performance [25-40]</span>
                      </span>

                    </p>

                    <p class="col-4 ml-auto d-flex flex-column">

                      <span class="">
                        <i class="fas fa-square text-warning"></i>
                        <span class="">Poor Performance [11-24]</span>
                      </span>

                      <span class="">
                        <i class="fas fa-square text-danger"></i>
                        <span class="">Bad Performance [Upto 10]</span>
                      </span>

                    </p>
                  </div>
                  <!-- /.d-flex -->

                  <div class="position-relative mb-4" id="sales-chart-month-user-div"></div>

                  <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                      <i class="fas fa-square text-primary"></i> <span class="bottom-text"></span>
                    </span>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>

          </div>
          <!-- /.row -->


          <!-- user Year order Row -->
          <div class="row mt-4">
            <div class="col-12">
              <div class="container-fluid">
                <div class="row mb-2">
                  <div class="col-sm-6">
                    <h2 class="m-0">Year Sales by SEOs</h2>
                  </div>
                  <div class="col-sm-6 text-right">
                    <form id="form-year-user-report">
                      @csrf()
                      <div class="form-row">
                        <div class="col-md-5">
                        </div>
                        <div class="col-md-3">
                          <label class="col-form-label">Select Year: </label>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <select class="form-control" name="sales_year" id="sales_year" style="width: 100%;">
                              @for($i=1900; $i <= 2099; $i++) @if($i==date("Y")) <option value="{{$i}}" selected>{{$i}}</option>
                                @else
                                <option value="{{$i}}">{{$i}}</option>
                                @endif

                                @endfor
                            </select>
                          </div>
                        </div>
                        <div class="col-md-1 text-center">
                          <button type="submit" class="btn btn-primary"><i class="fas fa-sync"></i></button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- user Year order Row -->
          <div class="row">

            <div class="col-lg-12">

              <div class="card" id="sales-chart-year-user-card">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title text-bold"></h3>
                  </div>
                </div>
                <div class="card-body">
                  <div class="d-flex">
                    <p class="d-flex flex-column">
                      <span class="text-bold text-lg text-danger total-sales"></span>
                      <span>Total Sales</span>
                    </p>
                    <p class="ml-auto d-flex flex-column text-right"></p>
                  </div>
                  <!-- /.d-flex -->

                  <div class="position-relative mb-4" id="sales-chart-year-user-div"></div>

                  <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                      <i class="fas fa-square text-primary"></i> <span class="bottom-text"></span>
                    </span>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>

          </div>
          <!-- /.row -->





        </div>

      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->




    @include('user_template.footer')


  </div>
  <!-- ./wrapper -->

  @include('user_template.scripts')

  <!-- OPTIONAL SCRIPTS -->
  <script src="{{url('')}}/layout/plugins/chart.js/Chart.min.js"></script>


  <script>
    var isAjax = false;

    var Toast = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: false,
      timer: 3000
    });


    $(function() {


      //year sales
      $('#form-year-report').on('submit', function(event) {
        event.preventDefault();

        if (!isAjax) {

          isAjax = true;
          let submitBtn = $(this).children().find('button[type=submit]');
          submitBtn.attr('disabled', 'true');
          let btnText = submitBtn.html();
          activeLoadingBtn2(submitBtn);

          $.ajax({
            type: 'POST',
            url: `{{url('')}}/ajax/seo/order-stats/calender-year`,
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: (res) => {

              if (res.code === 200) {


                if (res.data.length > 0) {
                  yearSalesChart(res);
                  yearSalesLineChart(res);
                } else {
                  Toast.fire({
                    icon: 'error',
                    title: 'No data found'
                  });
                }

              } else if (res.code === 100) {
                // showInvalidFields(res.err);
              } else {
                Toast.fire({
                  icon: 'error',
                  title: res.msg
                });
              }

              isAjax = false;
              submitBtn.removeAttr('disabled');
              resetLoadingBtn(submitBtn, btnText);
            },
            error: (xhr, status, err) => {
              ajaxErrorCalback(xhr, status, err);
              isAjax = false;

              submitBtn.removeAttr('disabled');
              resetLoadingBtn(submitBtn, btnText);
            }
          });
        }
      });


      //year sales users
      $('#form-year-user-report').on('submit', function(event) {
        event.preventDefault();

        if (!isAjax) {

          isAjax = true;
          let submitBtn = $(this).children().find('button[type=submit]');
          submitBtn.attr('disabled', 'true');
          let btnText = submitBtn.html();
          activeLoadingBtn2(submitBtn);

          $.ajax({
            type: 'POST',
            url: `{{url('')}}/ajax/seo/order-stats/calender-year-users`,
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: (res) => {

              if (res.code === 200) {

                if (res.data.length > 0) {
                  userYearSalesChart(res);
                } else {
                  Toast.fire({
                    icon: 'error',
                    title: 'No data found'
                  });
                }

              } else if (res.code === 100) {
                // showInvalidFields(res.err);
              } else {
                Toast.fire({
                  icon: 'error',
                  title: res.msg
                });
              }

              isAjax = false;
              submitBtn.removeAttr('disabled');
              resetLoadingBtn(submitBtn, btnText);
            },
            error: (xhr, status, err) => {
              ajaxErrorCalback(xhr, status, err);
              isAjax = false;

              submitBtn.removeAttr('disabled');
              resetLoadingBtn(submitBtn, btnText);
            }
          });
        }
      });


      //month sales
      $('#form-month-report').on('submit', function(event) {
        event.preventDefault();

        if (!isAjax) {

          isAjax = true;
          let submitBtn = $(this).children().find('button[type=submit]');
          submitBtn.attr('disabled', 'true');
          let btnText = submitBtn.html();
          activeLoadingBtn2(submitBtn);

          $.ajax({
            type: 'POST',
            url: `{{url('')}}/ajax/seo/order-stats/calender-month`,
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: (res) => {

              if (res.code === 200) {


                if (res.data.length > 0) {
                  monthSalesChart(res);
                  monthSalesLineChart(res);
                } else {
                  Toast.fire({
                    icon: 'error',
                    title: 'No data found'
                  });
                }

              } else if (res.code === 100) {
                // showInvalidFields(res.err);
              } else {
                Toast.fire({
                  icon: 'error',
                  title: res.msg
                });
              }

              isAjax = false;
              submitBtn.removeAttr('disabled');
              resetLoadingBtn(submitBtn, btnText);
            },
            error: (xhr, status, err) => {
              ajaxErrorCalback(xhr, status, err);
              isAjax = false;

              submitBtn.removeAttr('disabled');
              resetLoadingBtn(submitBtn, btnText);
            }
          });
        }
      });

      //month sales users
      $('#form-month-user-report').on('submit', function(event) {
        event.preventDefault();

        if (!isAjax) {

          isAjax = true;
          let submitBtn = $(this).children().find('button[type=submit]');
          submitBtn.attr('disabled', 'true');
          let btnText = submitBtn.html();
          activeLoadingBtn2(submitBtn);

          $.ajax({
            type: 'POST',
            url: `{{url('')}}/ajax/seo/order-stats/calender-month-users`,
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: (res) => {

              if (res.code === 200) {


                if (res.data.length > 0) {
                  userMonthSalesChart(res);
                  // userMonthSalesLineChart(res);
                } else {
                  Toast.fire({
                    icon: 'error',
                    title: 'No data found'
                  });
                }

              } else if (res.code === 100) {
                // showInvalidFields(res.err);
              } else {
                Toast.fire({
                  icon: 'error',
                  title: res.msg
                });
              }

              isAjax = false;
              submitBtn.removeAttr('disabled');
              resetLoadingBtn(submitBtn, btnText);
            },
            error: (xhr, status, err) => {
              ajaxErrorCalback(xhr, status, err);
              isAjax = false;

              submitBtn.removeAttr('disabled');
              resetLoadingBtn(submitBtn, btnText);
            }
          });
        }
      });

    });


    //year sales
    function yearSalesChart(response) {

      let monthsData = [];
      let salesData = [];
      let totalOrder = 0;

      //filter months and orders
      response.data.forEach((ele, index) => {
        monthsData[index] = ele.month;
        salesData[index] = ele.orders;

        totalOrder += eval(ele.orders);
      });

      $('#sales-chart-card .card-title').html(`Sales in Year ${response.year}`);
      $('#sales-chart-card .bottom-text').html(`Year ${response.year}`);
      $('#sales-chart-card .total-sales').html(totalOrder);

      let ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
      };

      let mode = 'index';
      let intersect = true;

      let yearSalesChartDiv = $('#sales-chart-div');
      yearSalesChartDiv.html('');
      yearSalesChartDiv.append(`<canvas id="sales-chart" height="200"></canvas>`);

      let yearSalesChart = $('#sales-chart');

      // eslint-disable-next-line no-unused-vars
      let salesChart = new Chart(yearSalesChart, {
        type: 'bar',
        data: {
          labels: monthsData,
          datasets: [{
            // label: response.year,
            backgroundColor: '#007bff',
            borderColor: '#007bff',
            data: salesData
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          tooltips: {
            mode: mode,
            intersect: intersect
          },
          hover: {
            mode: mode,
            intersect: intersect
          },
          legend: {
            display: false,
          },
          scales: {
            yAxes: [{
              display: true,
              gridLines: {
                display: true,
                // lineWidth: '4px',
                // color: 'rgba(0, 0, 0, .2)',
                // zeroLineColor: 'transparent'
              },
              ticks: $.extend({
                beginAtZero: true,
                // Include a dollar sign in the ticks
                callback: function(value) {
                  if (value >= 1000) {
                    value /= 1000;
                    value += 'k';
                  }
                  return value;
                }
              }, ticksStyle)
            }],
            xAxes: [{
              display: true,
              gridLines: {
                display: false
              },
              ticks: ticksStyle
            }]
          }
        }
      });


    }

    function yearSalesLineChart(response) {

      let monthsData = [];
      let salesData = [];
      let totalOrder = 0;

      //filter months and orders
      response.data.forEach((ele, index) => {
        monthsData[index] = ele.month;
        salesData[index] = ele.orders;

        totalOrder += eval(ele.orders);
      });

      $('#sales-line-chart-card .card-title').html(`Sales in Year ${response.year}`);
      $('#sales-line-chart-card .bottom-text').html(`Year ${response.year}`);
      $('#sales-line-chart-card .total-sales').html(totalOrder);

      let ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
      };

      let mode = 'index';
      let intersect = true;

      let yearSalesLineChartDiv = $('#sales-line-chart-div');
      yearSalesLineChartDiv.html('');
      yearSalesLineChartDiv.append(`<canvas id = "sales-line-chart" height = "200"></canvas>`);


      let yearSalesLineChart = $('#sales-line-chart');
      // eslint-disable-next-line no-unused-vars
      let visitorsChart = new Chart(yearSalesLineChart, {
        data: {
          labels: monthsData,
          datasets: [{
            type: 'line',
            data: salesData,
            backgroundColor: 'transparent',
            borderColor: '#007bff',
            pointBorderColor: '#007bff',
            pointBackgroundColor: '#007bff',
            fill: false
            // pointHoverBackgroundColor: '#007bff',
            // pointHoverBorderColor    : '#007bff'
          }, ]
        },
        options: {
          maintainAspectRatio: false,
          tooltips: {
            mode: mode,
            intersect: intersect
          },
          hover: {
            mode: mode,
            intersect: intersect
          },
          legend: {
            display: false
          },
          scales: {
            yAxes: [{
              // display: false,
              gridLines: {
                display: true,
                // lineWidth: '4px',
                // color: 'rgba(0, 0, 0, .2)',
                // zeroLineColor: 'transparent'
              },
              ticks: $.extend({
                beginAtZero: true,
                // suggestedMax: 200
              }, ticksStyle)
            }],
            xAxes: [{
              display: true,
              gridLines: {
                display: false
              },
              ticks: ticksStyle
            }]
          }
        }
      })
    }

    function getYearSalesData() {
      let isAjax = false;
      if (!isAjax) {

        isAjax = true;

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/seo/order-stats/calender-year`,
          data: {
            _token: $('#csrf_token_ajax').val()
          },
          // contentType: json,
          // processData: true,
          success: function(res) {

            if (res.code === 200) {

              if (res.data.length > 0) {
                yearSalesChart(res);
                yearSalesLineChart(res);
              } else {
                Toast.fire({
                  icon: 'error',
                  title: 'No sales data found'
                });
              }

            } else if (res.code === 100) {
              showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });
            }

            isAjax = false;
          },
          error: function(xhr, status, err) {
            ajaxErrorCalback(xhr, status, err);
            isAjax = false;
          }
        });
      }
    }

    getYearSalesData();


    // Month orders
    function monthSalesChart(response) {

      let dateData = [];
      let salesData = [];
      let totalOrder = 0;

      //filter months and orders
      response.data.forEach((ele, index) => {
        dateData[index] = ele.date;
        salesData[index] = ele.orders;

        totalOrder += eval(ele.orders);
      });

      $('#sales-chart-month-card .card-title').html(`Sales in ${response.year}`);
      $('#sales-chart-month-card .bottom-text').html(`${response.year}`);
      $('#sales-chart-month-card .total-sales').html(totalOrder);

      let ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
      };

      let mode = 'index';
      let intersect = true;

      let yearSalesChartDiv = $('#sales-chart-month-div');
      yearSalesChartDiv.html('');
      yearSalesChartDiv.append(`<canvas id="sales-chart-month" height="200"></canvas>`);

      let yearSalesChart = $('#sales-chart-month');

      // eslint-disable-next-line no-unused-vars
      let salesChart = new Chart(yearSalesChart, {
        type: 'bar',
        data: {
          labels: dateData,
          datasets: [{
            // label: response.year,
            backgroundColor: '#007bff',
            borderColor: '#007bff',
            data: salesData
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          tooltips: {
            mode: mode,
            intersect: intersect
          },
          hover: {
            mode: mode,
            intersect: intersect
          },
          legend: {
            display: false,
          },
          scales: {
            yAxes: [{
              display: true,
              gridLines: {
                display: true,
                // lineWidth: '4px',
                // color: 'rgba(0, 0, 0, .2)',
                // zeroLineColor: 'transparent'
              },
              ticks: $.extend({
                beginAtZero: true,
                // Include a dollar sign in the ticks
                callback: function(value) {
                  if (value >= 1000) {
                    value /= 1000;
                    value += 'k';
                  }
                  return value;
                }
              }, ticksStyle)
            }],
            xAxes: [{
              display: true,
              gridLines: {
                display: false
              },
              ticks: ticksStyle
            }]
          }
        }
      });


    }

    function monthSalesLineChart(response) {

      let dateData = [];
      let salesData = [];
      let totalOrder = 0;

      //filter months and orders
      response.data.forEach((ele, index) => {
        dateData[index] = ele.date;
        salesData[index] = ele.orders;

        totalOrder += eval(ele.orders);
      });

      $('#sales-line-chart-month-card .card-title').html(`Sales in ${response.year}`);
      $('#sales-line-chart-month-card .bottom-text').html(`${response.year}`);
      $('#sales-line-chart-month-card .total-sales').html(totalOrder);

      let ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
      };

      let mode = 'index';
      let intersect = true;

      let yearSalesLineChartDiv = $('#sales-line-chart-month-div');
      yearSalesLineChartDiv.html('');
      yearSalesLineChartDiv.append(`<canvas id = "sales-line-chart-month" height = "200"></canvas>`);


      let yearSalesLineChart = $('#sales-line-chart-month');
      // eslint-disable-next-line no-unused-vars
      let visitorsChart = new Chart(yearSalesLineChart, {
        data: {
          labels: dateData,
          datasets: [{
            type: 'line',
            data: salesData,
            backgroundColor: 'transparent',
            borderColor: '#007bff',
            pointBorderColor: '#007bff',
            pointBackgroundColor: '#007bff',
            fill: false
            // pointHoverBackgroundColor: '#007bff',
            // pointHoverBorderColor    : '#007bff'
          }, ]
        },
        options: {
          maintainAspectRatio: false,
          tooltips: {
            mode: mode,
            intersect: intersect
          },
          hover: {
            mode: mode,
            intersect: intersect
          },
          legend: {
            display: false
          },
          scales: {
            yAxes: [{
              // display: false,
              gridLines: {
                display: true,
                // lineWidth: '4px',
                // color: 'rgba(0, 0, 0, .2)',
                // zeroLineColor: 'transparent'
              },
              ticks: $.extend({
                beginAtZero: true,
                // suggestedMax: 200
              }, ticksStyle)
            }],
            xAxes: [{
              display: true,
              gridLines: {
                display: false
              },
              ticks: ticksStyle
            }]
          }
        }
      })
    }

    function getMonthSalesData() {
      let isAjax = false;
      if (!isAjax) {

        isAjax = true;

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/seo/order-stats/calender-month`,
          data: {
            _token: $('#csrf_token_ajax').val()
          },
          // contentType: json,
          // processData: true,
          success: function(res) {

            if (res.code === 200) {

              if (res.data.length > 0) {
                monthSalesChart(res);
                monthSalesLineChart(res);
              } else {
                Toast.fire({
                  icon: 'error',
                  title: 'No sales data found'
                });
              }

            } else if (res.code === 100) {
              showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });
            }

            isAjax = false;
          },
          error: function(xhr, status, err) {
            ajaxErrorCalback(xhr, status, err);
            isAjax = false;
          }
        });
      }
    }

    getMonthSalesData();


    //user Year sales
    function userYearSalesChart(response) {

      let usernames = [];
      let salesData = [];
      let totalOrder = 0;

      //filter months and orders
      response.data.forEach((ele, index) => {
        usernames[index] = ele.username;
        salesData[index] = ele.orders;

        totalOrder += eval(ele.orders);
      });

      $('#sales-chart-year-user-card .card-title').html(`Sales in Year ${response.year}`);
      $('#sales-chart-year-user-card .bottom-text').html(`Year ${response.year}`);
      $('#sales-chart-year-user-card .total-sales').html(totalOrder);

      let ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
      };

      let mode = 'index';
      let intersect = true;

      let yearSalesChartDiv = $('#sales-chart-year-user-div');
      yearSalesChartDiv.html('');
      yearSalesChartDiv.append(`<canvas id="sales-chart-year-user" height="200"></canvas>`);

      let yearSalesChart = $('#sales-chart-year-user');

      // eslint-disable-next-line no-unused-vars
      let salesChart = new Chart(yearSalesChart, {
        type: 'horizontalBar',
        data: {
          labels: usernames,
          datasets: [{
            // label: 'data',
            backgroundColor: '#007bff',
            borderColor: '#007bff',
            data: salesData
          }]
        },
        options: {
          indexAxis: 'y',
          responsive: true,
          maintainAspectRatio: true,
          tooltips: {
            mode: mode,
            intersect: intersect
          },
          hover: {
            mode: mode,
            intersect: intersect
          },
          legend: {
            display: false,
          },
          scales: {
            yAxes: [{
              display: true,
              gridLines: {
                display: true,
                // lineWidth: '4px',
                // color: 'rgba(0, 0, 0, .2)',
                // zeroLineColor: 'transparent'
              },
              ticks: $.extend({
                beginAtZero: true,
                // Include a dollar sign in the ticks
                callback: function(value) {
                  if (value >= 1000) {
                    value /= 1000;
                    value += 'k';
                  }
                  return value;
                }
              }, ticksStyle)
            }],
            xAxes: [{
              display: true,
              gridLines: {
                display: true
              },
              ticks: ticksStyle
            }]
          }
        },

      });


    }

    function getUserYearSalesData() {
      let isAjax = false;
      if (!isAjax) {

        isAjax = true;

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/seo/order-stats/calender-year-users`,
          data: {
            _token: $('#csrf_token_ajax').val()
          },
          // contentType: json,
          // processData: true,
          success: function(res) {

            if (res.code === 200) {

              if (res.data.length > 0) {
                userYearSalesChart(res);
              } else {
                Toast.fire({
                  icon: 'error',
                  title: 'No sales data found'
                });
              }

            } else if (res.code === 100) {
              showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });
            }

            isAjax = false;
          },
          error: function(xhr, status, err) {
            ajaxErrorCalback(xhr, status, err);
            isAjax = false;
          }
        });
      }
    }

    getUserYearSalesData();


    //user month sales
    function userMonthSalesChart(response) {

      let usernames = [];
      let salesData = [];
      let totalOrder = 0;
      let backgroundColor = Array();

      //filter months and orders
      response.data.forEach((ele, index) => {
        usernames[index] = ele.username;
        salesData[index] = ele.orders;
        backgroundColor[index] = ele.color;

        totalOrder += eval(ele.orders);
      });

      $('#sales-chart-month-user-card .card-title').html(`Sales in ${response.month}`);
      $('#sales-chart-month-user-card .bottom-text').html(`${response.month}`);
      $('#sales-chart-month-user-card .total-sales').html(totalOrder);

      let ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
      };

      let mode = 'index';
      let intersect = true;

      let yearSalesChartDiv = $('#sales-chart-month-user-div');
      yearSalesChartDiv.html('');
      yearSalesChartDiv.append(`<canvas id="sales-chart-month-user" height="200"></canvas>`);

      let yearSalesChart = $('#sales-chart-month-user');

      // eslint-disable-next-line no-unused-vars
      let salesChart = new Chart(yearSalesChart, {
        type: 'horizontalBar',
        data: {
          labels: usernames,
          datasets: [{
            // label: 'data',
            backgroundColor: backgroundColor,
            borderColor: backgroundColor,
            data: salesData
          }]
        },
        options: {
          indexAxis: 'y',
          responsive: true,
          maintainAspectRatio: true,
          tooltips: {
            mode: mode,
            intersect: intersect
          },
          hover: {
            mode: mode,
            intersect: intersect
          },
          legend: {
            display: false,
          },
          scales: {
            yAxes: [{
              display: true,
              gridLines: {
                display: true,
                // lineWidth: '4px',
                // color: 'rgba(0, 0, 0, .2)',
                // zeroLineColor: 'transparent'
              },
              ticks: $.extend({
                beginAtZero: true,
                // Include a dollar sign in the ticks
                callback: function(value) {
                  if (value >= 1000) {
                    value /= 1000;
                    value += 'k';
                  }
                  return value;
                }
              }, ticksStyle)
            }],
            xAxes: [{
              display: true,
              gridLines: {
                display: true
              },
              ticks: ticksStyle
            }]
          }
        },

      });


    }

    function getUserMonthSalesData() {
      let isAjax = false;
      if (!isAjax) {

        isAjax = true;

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/seo/order-stats/calender-month-users`,
          data: {
            _token: $('#csrf_token_ajax').val()
          },
          // contentType: json,
          // processData: true,
          success: function(res) {

            if (res.code === 200) {

              if (res.data.length > 0) {
                userMonthSalesChart(res);
              } else {
                Toast.fire({
                  icon: 'error',
                  title: 'No sales data found'
                });
              }

            } else if (res.code === 100) {
              showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });
            }

            isAjax = false;
          },
          error: function(xhr, status, err) {
            ajaxErrorCalback(xhr, status, err);
            isAjax = false;
          }
        });
      }
    }

    getUserMonthSalesData();
  </script>


</body>

</html>