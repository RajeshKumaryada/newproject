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


      <div class="content">
        <div class="container-fluid">

          <div class="row pt-2">
            <div class="col-12">
              <div class="container-fluid">
                <div class="row mb-2">
                  <div class="col-sm-6">
                    <h2 class="m-0">Month Order By Sales Teams</h2>
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
          <div class="row" id="chart-container"></div>
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
            url: `{{url('')}}/ajax/seo/order-stats/teams`,
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: (res) => {

              if (res.code === 200) {


                if (res.data.length > 0) {
                  monthSalesChart(res);
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




    // Month orders
    function monthSalesChart(response) {

      let chartContainer = $('#chart-container');
      chartContainer.html('');

      let ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
      };

      let mode = 'index';
      let intersect = true;

      let teamNameData = Array();
      let teamOrderData = Array();
      let totalOrderByAllTeams = 0;


      response.data.forEach((ele, idx) => {
        let dateData = [];
        let salesData = [];
        let totalOrder = 0;

        //filter months and orders
        ele.orders.forEach((ord, ordIdx) => {
          dateData[ordIdx] = ord.date;
          salesData[ordIdx] = ord.orders;

          totalOrder += eval(ord.orders);

        });


        teamNameData[idx] = ele.team_name;
        teamOrderData[idx] = totalOrder;
        totalOrderByAllTeams += totalOrder;


        let chartDivObj = {
          chartId: `bar-${idx}`,
          canvasId: `bar-${idx}`,
          cardTitle: `Sales in ${response.month} By ${ele.team_name} - ${ele.team_leaders}`,
          totalSales: totalOrder,
          bottomText: response.month
        };

        let chartDiv = barChartDiv(chartDivObj);

        chartContainer.append(chartDiv);

        let salesChartDiv = $(`#chart-canvas-div-${chartDivObj.chartId}`);
        // salesChartDiv.html('');
        salesChartDiv.append(`<canvas id="sales-chart-${chartDivObj.chartId}" height="200"></canvas>`);


        let yearSalesChart = $(`#sales-chart-${chartDivObj.chartId}`);


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

      });

      salesTeamCompareChart(teamNameData, teamOrderData, totalOrderByAllTeams, response.month);

    }


    function salesTeamCompareChart(teamNames, teamOrders, teamOrdersAllTeam, month) {

      let chartContainer = $('#chart-container');

      let ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
      };

      let mode = 'index';
      let intersect = true;

      let chartDivObj = {
        chartId: `bar-cmp`,
        canvasId: `bar-cmp`,
        cardTitle: `Compare Sales in ${month} By All Teams`,
        totalSales: teamOrdersAllTeam,
        bottomText: month
      };

      let chartDiv = barChartDiv(chartDivObj);

      chartContainer.prepend(chartDiv);

      let salesChartDiv = $(`#chart-canvas-div-${chartDivObj.chartId}`);
      // salesChartDiv.html('');
      salesChartDiv.append(`<canvas id="sales-chart-${chartDivObj.chartId}" height="200"></canvas>`);


      let yearSalesChart = $(`#sales-chart-${chartDivObj.chartId}`);


      // // eslint-disable-next-line no-unused-vars
      let salesChart = new Chart(yearSalesChart, {
        type: 'bar',
        data: {
          labels: teamNames,
          datasets: [{
            // label: response.year,
            backgroundColor: '#007bff',
            borderColor: '#007bff',
            data: teamOrders
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
              maxBarThickness: 30,
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


    function barChartDiv(obj) {
      let ele = `<div class="col-md-12">
                  <div class="card" id="sales-chart-card-${obj.chartId}">
                    <div class="card-header border-0">
                      <div class="d-flex justify-content-between">
                        <h3 class="card-title text-bold">${obj.cardTitle}</h3>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="d-flex">
                        <p class="d-flex flex-column">
                          <span class="text-bold text-lg text-danger total-sales">${obj.totalSales}</span>
                          <span>Total Sales</span>
                        </p>
                        <p class="ml-auto d-flex flex-column text-right"></p>
                      </div>
                      <!-- /.d-flex -->

                      <div class="position-relative mb-4" id="chart-canvas-div-${obj.canvasId}"></div>

                      <div class="d-flex flex-row justify-content-end">
                        <span class="mr-2">
                          <i class="fas fa-square text-primary"></i> <span class="bottom-text">${obj.bottomText}</span>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>`;

      return ele;
    }


    function getMonthSalesData() {
      let isAjax = false;
      if (!isAjax) {

        isAjax = true;

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/seo/order-stats/teams`,
          data: {
            _token: $('#csrf_token_ajax').val()
          },
          // contentType: json,
          // processData: true,
          success: function(res) {

            if (res.code === 200) {

              if (res.data.length > 0) {
                monthSalesChart(res);
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
  </script>


</body>

</html>