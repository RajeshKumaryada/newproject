<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"Create SEO Team"])
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
              <h1 class="m-0">Create SEO Team</h1>
            </div>
          </div>
        </div>
      </div>


      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Form</h3>
                </div>
                <!-- /.card-header -->

                <form id="add-user-form">
                  <div class="card-body">
                    @csrf()
                    <div class="row">

                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Team Name [Team name should be unique]</label>
                          <input type="text" name="team_name" id="team_name" class="form-control cap-case">
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Team Type</label>
                          <select name="team_type" id="team_type" class="form-control">
                            <option value="">--Select--</option>
                            @foreach($teamType as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Select Team Leader(s) [You may select multiple team leader]</label>
                          <select class="form-control select2bs4" name="leader_id[]" id="leader_id" style="width: 100%;" multiple>
                            @foreach($users as $row)
                            <option value="{{$row->user_id}}">{{$row->username}} - {{$row->designation()->first()->des_name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Select Team Member(s)</label>
                          <select class="form-control select2bs4" name="members_id[]" id="members_id" style="width: 100%;height:100px;" multiple>
                            @foreach($users as $row)
                            <option value="{{$row->user_id}}">{{$row->username}} - {{$row->designation()->first()->des_name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="card-footer">
                    <button type="submit" id="frm-submit-btn" class="btn btn-primary float-right">Create</button>
                  </div>

                </form>


              </div>
              <!-- /.card -->

            </div>
            <!--/.col (left) -->

          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>


      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Team List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="data-tbl" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Menu</th>
                        <th>Team Name</th>
                        <th>Team Type</th>
                        <th>Team Size</th>
                        <th>Members</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>

            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>


    </div>
    <!-- /.content-wrapper -->

    @include('admin.template.footer')


  </div>
  <!-- ./wrapper -->

  @include('admin.template.scripts')
  <script>
    var dataTbl;
    $(function() {
      $("#data-tbl").DataTable({
        columnDefs: [{
          bSortable: false,
          targets: [1]
        }],
        "paging": true,
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#data-tbl_wrapper .col-md-6:eq(0)');

      dataTbl = $("#data-tbl").DataTable();
      getTeamList(dataTbl);
    });



    /**
     * get list for table 
     */
    function getTeamList(dataTbl) {
      dataTbl.clear().draw();
      let url = `{{url('')}}/ajax/admin/seo-team/manage/list`;
      getAjaxData(dataTbl, url, setTableData);
    }



    /**
     * set table data
     */
    function setTableData(tbl_id, response) {

      let count = 0;
      let menuEle = null;



      //for loop
      response.data.forEach((ele, idx) => {

        let teamMembers = '';

        menuEle = `<div class="text-center">
            <span class="user-badge text-primary"><i data-id="${ele.wt_id}" class="fas fa-edit cur-ptr edit-team-info"></i></span>
            <span class="user-badge text-danger"><i data-id="${ele.wt_id}" class="fas fa-trash cur-ptr delete-team"></i></span>
          </div>`;

        ele.work_team_members.forEach(row => {
          if (row.member_type === "team_leader") {
            teamMembers += `<span class="badge badge-danger user-badge" title="Team Leader" >${row.username.username}</span>`;
          } else {
            teamMembers += `<span class="badge badge-success user-badge" title="Team Member">${row.username.username}</span>`;
          }

        });

        tbl_id.row.add(
          [
            (++count),
            menuEle,
            ele.team_name,
            ele.team_type,
            ele.work_team_members.length,
            teamMembers
          ]
        ).draw(false);

      });
      //end for loop
    }

    let isAjax = false;
    let frmEle = "#add-user-form";

    $(frmEle).on('submit', function(e) {
      e.preventDefault();
      let formEle = frmEle;
      if (!isAjax) {
        isAjax = true;
        $(this).children('div.card-footer').children('button[type=submit]').attr('disabled', 'true');
        let btnText = $('#frm-submit-btn').html();
        activeLoadingBtn("#frm-submit-btn");

        let Toast = Swal.mixin({
          toast: true,
          position: 'center',
          showConfirmButton: false,
          timer: 3000
        });

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/admin/seo-team/manage/create`,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {

            if (res.code === 200) {
              Toast.fire({
                icon: 'success',
                title: res.msg
              });

              getTeamList(dataTbl);

              $(frmEle).trigger("reset");
              $(".select2bs4").val(null).trigger('change');
            } else if (res.code === 100) {
              showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });
            }

            isAjax = false;
            $(formEle).children('div.card-footer').children('button[type=submit]').removeAttr('disabled');
            resetLoadingBtn("#frm-submit-btn", btnText);
          },
          error: function(xhr, status, err) {
            ajaxErrorCalback(xhr, status, err);

            isAjax = false;
            $(formEle).children('div.card-footer').children('button[type=submit]').removeAttr('disabled');
            resetLoadingBtn("#frm-submit-btn", btnText);
          }
        });
      }

    });


    /**
     * Edit team info
     */
    $('#data-tbl').on('click', '.edit-team-info', function() {
      if (!confirm('Are you sure to edit?')) {
        return false;
      }

      let teamId = $(this).attr('data-id');

      window.open(`{{url('')}}/admin/seo-team/manage/edit-info/${teamId}`, '_self');
    });

    /**
     * delete team
     */
    $('#data-tbl').on('click', '.delete-team', function() {

      if (!confirm('Are you sure to delete?')) {
        return false;
      }

      let teamId = $(this).attr('data-id');

      let Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
      });

      $.ajax({
        type: 'POST',
        url: `{{url('')}}/ajax/admin/seo-team/manage/delete`,
        data: {
          team_id: teamId,
          _token: $('#csrf_token_ajax').val()
        },
        success: function(res) {

          if (res.code === 200) {
            Toast.fire({
              icon: 'success',
              title: res.msg
            });

            getTeamList(dataTbl);
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

    });
  </script>

</body>

</html>