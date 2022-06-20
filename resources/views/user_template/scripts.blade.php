<!-- jQuery -->
<script src="{{ url('') }}/layout/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ url('') }}/layout/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- Get Assign click update Id -->
<script>
    var active = 0;
    $('#active').hide();
    var x;
    var t;
    const music = new Audio(`{{url('')}}/users/alarm/get-audio/alarm_tone.mp3`);
    function  getAudio(){

                 music.loop =true;
                 //play the music
                 music.play();

    }

    // function startFunction(t) {
    //     // alert(t);

    //     // $('#taskStatus').html("Task Started");
    //     x = setInterval(alertFunction,  t*1000);
    // }

    function startFunction(t) {
          
          $.ajax({
                    type: 'GET',
                    url: `{{url('')}}/ajax/users/login-location/fetch-data`,
               
                    success: function(res) {
                      
                        if (res.code === 200) {
                          x = setInterval(alertFunction, t*1000);
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: res.msg
                            });
                        }

                    }
                });

          
        }

    // 5 min converted miliseconds 300000

    function alertFunction() {
        setTimeout(endTask,  5 * 6 * 1000);

        // $('#active').show();
        var overlay =
            `<div id="overlay" style="position:fixed;z-index:99999;display:block;text-align:center;left:20%;top:30%;width:100%;height:100%;" class="container">
                 <p id="taskStatus"></p>
                 <button class="star btn btn-danger btn-lg" id="active" onclick="isActive()">Continue Your work</button></div>`;
        $('body').prepend(overlay);

           getAudio();
           notifyMe();
        active = 0;
    }

    function isActive() {
        active = 1;

        music.loop = false;
        music.pause();
        $('#overlay').css("display", "none");
    }

    function endTask() {
        if (active == 0) {
            music.loop = false;
            music.pause();
            clearInterval(x);
            $('#overlay').css("display", "none");
            getEndTask();

            // $('#active').hide();

        } else {
            // $('#taskStatus').html("User is Active | Task is Running");
        }
    }

    function getEndTask() {
        $.ajax({
            type: 'GET',
            url: `{{ url('') }}/users/alarm/end-task`,

            success: function(res) {

                if (res.code === 200) {

                } else {
                    Toast.fire({
                        icon: 'error',
                        title: res.msg
                    });
                }

            }
        });


    }

            // request permission on page load
            document.addEventListener('DOMContentLoaded', function () {
            if (!Notification) {
                alert('Desktop notifications not available in your browser. Try Chromium.');
                return;
            }

            if (Notification.permission !== 'granted')
                Notification.requestPermission();
        });


        function notifyMe() {
            if (Notification.permission !== 'granted')
                Notification.requestPermission();
            else {
                var notification = new Notification('Notification title', {
                    icon: document.getElementById('fetch-noti-logo').value,
                    body: 'Continue Your Work!',
                });
                notification.onclick = function () {
                    // window.open('');
                };
            }
        }

</script>
<script>
    $(document).ready(function() {


        $.ajax({

            url: `{{ url('') }}/users/alarm/fetch-alarm`,

            success: function(res) {

                //  alert(res.data.result);
                if (res.code === 200) {

                    if (res.com_status_cw === 0) {
                        // alert(res.data.result);
                        if (res.data.result != '') {
                            clearInterval(x);

                            startFunction(res.data.result);
                            //   alert(res.audio);
                            // getAudio(res.audio);
                        }
                    }
                    if (res.com_status_des === 0) {

                        if (res.data.result != '') {
                            clearInterval(x);
                            startFunction(res.data.result);
                            //   alert(res.audio);
                            // getAudio(res.audio);
                        }

                    }
                    if (res.com_status_dev === 0) {

                        if (res.data.result != '') {
                            clearInterval(x);
                            startFunction(res.data.result);
                            //   alert(res.audio);
                            // getAudio(res.audio);
                        }

                    }
                    if (res.com_status_hr === 0) {

                        if (res.data.result != '') {
                            clearInterval(x);
                            startFunction(res.data.result);
                            //   alert(res.audio);
                            // getAudio(res.audio);
                        }

                    }
                    if (res.com_status_seo === 0) {

                        if (res.data.result != '') {
                            clearInterval(x);
                            startFunction(res.data.result);
                            //   alert(res.audio);
                            // getAudio(res.audio);
                        }

                    }
                    if (res.com_status_des === 0) {

                        if (res.data.result != '') {
                            clearInterval(x);
                            startFunction(res.data.result);
                            //   alert(res.audio);
                            // getAudio(res.audio);
                        }

                    }
                    if (res.com_status_bckoffice === 0) {

                        if (res.data.result != '') {
                            clearInterval(x);
                            startFunction(res.data.result);
                            //   alert(res.audio);
                            // getAudio(res.audio);
                        }

                    }


                } else {
                    Toast.fire({
                        icon: 'error',
                        title: res.msg
                    });
                }

            }
        });

    });


    $('#assign-notify').on('click', function(e) {
        e.preventDefault();
        // alert('working');
        var snew = '';
        var id = $(this).attr('data-id');
        // var snew = id.split(' ',id);
        // alert(snew);
        var user_id = $(this).attr('data-user-id');


        $.ajax({
            type: 'POST',
            url: `{{ url('') }}/ajax/users/assign-task/user/assign-notify`,
            // data :new FormData(this),
            data: {
                id: id,
                user_id: user_id,
                _token: `{{ csrf_token() }}`,
            },
            // contentType: false,
            // processData: false,
            success: function(res) {

                if (res.code === 200) {
                    Toast.fire({
                        icon: 'success',
                        title: res.msg
                    });
                    window.location.reload();


                } else {
                    Toast.fire({
                        icon: 'error',
                        title: res.msg
                    });
                }

            }
        });

    });
</script>

<!-- Bootstrap 4 -->
<script src="{{ url('') }}/layout/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- overlayScrollbars -->
<script src="{{ url('') }}/layout/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ url('') }}/layout/dist/js/adminlte.min.js"></script>

<!-- <script src="{{ url('') }}/layout/dist/js/pages/dashboard.js"></script> -->


<!-- DataTables  & Plugins -->
<script src="{{ url('') }}/layout/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ url('') }}/layout/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ url('') }}/layout/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ url('') }}/layout/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ url('') }}/layout/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ url('') }}/layout/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ url('') }}/layout/plugins/jszip/jszip.min.js"></script>
<script src="{{ url('') }}/layout/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{ url('') }}/layout/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{ url('') }}/layout/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ url('') }}/layout/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ url('') }}/layout/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- SweetAlert2 -->
<script src="{{ url('') }}/layout/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="{{ url('') }}/layout/plugins/toastr/toastr.min.js"></script>

<!-- bs-custom-file-input -->
<script src="{{ url('') }}/layout/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>


<!-- Select2 -->
<script src="{{ url('') }}/layout/plugins/select2/js/select2.full.min.js"></script>

<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });

    $('.logout-link').on('click', function() {
        if (confirm('Are you sure to logout?')) {
            return true;
        }
        return false;
    });
</script>

<script>
    $(document).ready(function() {
        $.get("{{ url('') }}/ajax/users/assign-task/user/get-badges", function(data, status) {
            $('#badges-assign').html(data);
        });

    });

    // setInterval(function(){
    //   $.get("{{ url('') }}/ajax/users/assign-task/user/get-badges", function(data, status){
    //   $('#badges-assign').html(data);
    // });
    //  }, 5000);
</script>

<!-- Logelite -->
<script src="{{ url('') }}/script.js"></script>
<script>
    getLocation();
</script>
<script src="{{ url('') }}/notification.js"></script>
