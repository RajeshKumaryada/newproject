"use strict";

function getLocation() {

  let latLoc = '', lonLoc = '', errLoc = '';

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      function (position) {
        latLoc = position.coords.latitude;
        lonLoc = position.coords.longitude;
        sendDataAjax(latLoc, lonLoc, errLoc);
        // console.log(latLoc, lonLoc, errLoc);
      },
      function (error) {
        switch (error.code) {
          case error.PERMISSION_DENIED:
            errLoc = 'PERMISSION_DENIED';
            break;
          case error.POSITION_UNAVAILABLE:
            errLoc = 'POSITION_UNAVAILABLE';
            break;
          case error.TIMEOUT:
            errLoc = 'TIMEOUT';
            break;
          case error.UNKNOWN_ERROR:
            errLoc = 'UNKNOWN_ERROR';
            break;
        }
        // sendDataAjax();

        alert('Please allow location, otherwise you are unable to update work report!');
        // location.reload();
        // getLocation();
      }
    );
  } else {
    errLoc = "NO_SUPPORT";
    // sendDataAjax();
  }

}


function sendDataAjax(lat, lon, err) {
  // console.log(lat, lon, err);

  const xhttp = new XMLHttpRequest();
  xhttp.onload = function () {
    // console.log(this.status, this.readyState, this.responseText);
    //this.responseText,

    if (this.readyState == 4 && this.status == 200) {
      // let res = JSON.parse(this.responseText);
      // if (res.code === 100) {
      //   alert(res.msg);
      // }
    }
  }
  let url = document.getElementById('update-lat-lon').value;
  let token = document.getElementById('csrf_token_ajax').value;
  xhttp.open("POST", url);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(`_token=${token}&lat=${lat}&lon=${lon}&err=${err}`);
}


/**
 * ::::::::::::::
 * Append Child Select Tag
 * ::::::::::::::
 */
function appendChildSelect(eleId, data) {
  data.data.forEach((ele) => {
    let opt = document.createElement('option');
    opt.setAttribute('value', ele.id);
    opt.innerHTML = ele.value;
    $(eleId).append(opt);
  });
}


function appendChildSelect2(eleId, data) {
  data.data.forEach((ele) => {
    let opt = document.createElement('option');
    opt.setAttribute('value', ele.id);
    opt.innerHTML = ele.value;
    let match = this.match;
    // console.log(match);
    if (match == ele.id) {
      opt.setAttribute('selected', true);
    }
    $(eleId).append(opt);
  });
}



/**
 * ::::::::::::::
 * Generate Password
 * ::::::::::::::
 */
function generatePassword() {
  let length = 8, charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789", retVal = "";
  for (var i = 0, n = charset.length; i < length; ++i) {
    retVal += charset.charAt(Math.floor(Math.random() * n));
  }
  return retVal;
}



/**
 * ::::::::::::::
 * Generate Username
 * ::::::::::::::
 */
function generateUsername(in_str) {
  if (in_str != null && in_str != undefined && in_str != '') {
    in_str = in_str.split("@")[0];
    return in_str.replace(/[^a-zA-Z0-9]/g, '_');
  }

  return null;
}




/**
 * ::::::::::::::
 * Get Ajax Data
 * ::::::::::::::
 */
function getAjaxData(element, ajaxUrl, callback) {

  // console.log(args);

  $.ajax({
    type: 'GET',
    url: ajaxUrl,
    success: function (response) {
      // console.log(response);
      if (response.code === 200) {
        callback(element, response);
      }
    },
    error: function (error) {
      console.log("Error: ", error);
    }
  });

}



/**
 * ::::::::::::::
 * Send Ajax Data
 * ::::::::::::::
 */
function sendAjaxData(ajaxUrl, data, callback) {
  $.ajax({
    type: 'POST',
    url: ajaxUrl,
    data: data,
    success: function (response) {
      // console.log(response);
      if (response.code === 200) {
        callback(response);
      }
    },
    error: function (error) {
      console.log("Error: ", error);
    }
  });
}




/**
 * ::::::::::::::
 * Show Invalid Fields for Form Validation
 * ::::::::::::::
 */
function showInvalidFields(obj) {
  $.each(obj, function (key, value) {
    $(`#${key},.${key}`).addClass('is-invalid');
    $(`#${key}-error`).remove();
    let errEle = `<span id="${key}-error" class="error invalid-feedback">${value[0]}</span>`;
    $(`#${key}`).closest('.form-group').append(errEle);

    $(`#${key},.${key}`).on('focus change', function () {
      $(`#${key},.${key}`).removeClass('is-invalid');
      $(`#${key}-error`).remove();
    });
  });
}



/**
 * ::::::::::::::
 * Active Loading Button
 * ::::::::::::::
 */
function activeLoadingBtn(ele) {
  let tag = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`;
  $(ele).html(tag);
}

function activeLoadingBtn2(ele) {
  let tag = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
  $(ele).html(tag);
}




/**
 * ::::::::::::::
 * Reset Loading Button
 * ::::::::::::::
 */
function resetLoadingBtn(ele, txt) {
  $(ele).html(txt);
}




/**
 * ::::::::::::::
 * Run Active Task Time of the User
 * ::::::::::::::
 */
function runActiveTaskTime(timeArr, callback) {
  timeArr[2] = timeArr[2] + 1;
  if (timeArr[2] >= 60) {
    timeArr[1] = timeArr[1] + parseInt(Math.floor(timeArr[2] / 60));
    timeArr[2] = timeArr[2] % 60;
  }

  if (timeArr[1] >= 60) {
    timeArr[0] = timeArr[0] + parseInt(Math.floor(timeArr[1] / 60));
    timeArr[1] = timeArr[1] % 60;
  }

  callback(timeArr);
}




/**
 * ::::::::::::::
 * Active Task Time Format for the Users
 * ::::::::::::::
 */
function runActiveTaskTimeFormat(timeArr) {
  let str = "";
  if (timeArr[0] < 4) {
    str = `<span class='text-danger'>${timeArr[0]}h ${timeArr[1]}m ${timeArr[2]}s</span>`;
  } else if (timeArr[0] < 8) {
    str = `<span class='text-primary'>${timeArr[0]}h ${timeArr[1]}m ${timeArr[2]}s</span>`;
  } else {
    str = `<span class='text-success'>${timeArr[0]}h ${timeArr[1]}m ${timeArr[2]}s</span>`;
  }
  document.getElementById('tot_working_hours').innerHTML = str;
}





/**
 * ::::::::::::::
 * Calculate Work Duration
 * ::::::::::::::
 */
function calculateWorkDuration(startTime, _callback, endTime = null) {

  let date1 = new Date(startTime);
  let date2 = new Date();

  if (endTime != null) {
    date2 = new Date(endTime);
  }

  let diffInTime = date2.getTime() - date1.getTime();

  let sec = Math.floor(diffInTime / 1000);
  let min = Math.floor(sec / 60);
  sec %= 60;
  let hrs = Math.floor(min / 60);
  min %= 60;

  return _callback([hrs, min, sec]);

}





/**
 * ::::::::::::::
 * Working DurationFormat
 * ::::::::::::::
 */
function workingDurationFormat(timeArr) {
  let str = "";
  if (timeArr[0] < 4) {
    str = `<span class='text-danger font-weight-bold'>${timeArr[0]}h ${timeArr[1]}m ${timeArr[2]}s</span>`;
  } else if (timeArr[0] < 8) {
    str = `<span class='text-primary font-weight-bold'>${timeArr[0]}h ${timeArr[1]}m ${timeArr[2]}s</span>`;
  } else {
    str = `<span class='text-success font-weight-bold'>${timeArr[0]}h ${timeArr[1]}m ${timeArr[2]}s</span>`;
  }

  return str;
}




/**
 * 
 */
function trimStr(str, len = 80, suffix = '...') {

  if (str.length > len) {
    return `${str.substring(0, len)} ${suffix}`;
  }

  return str;

}


/**
 * 
 */
function n2br(str) {
  return str.replace(/(\r\n|\r|\n)/g, '<br>');
}


function ajaxErrorCalback(xhr, status, err = null) {
  alert(`${status} : ${xhr.status} - ${xhr.statusText}`);
  console.log(xhr, err);
}

function fecthNoticeBoardMsg() {
  getAjaxData('#notice-board', $('#fetch-noti-board-msg').val(), (ele, res) => {
    $(ele).html(`<marquee>${res.msg}</marquee>`);
  });
}

fecthNoticeBoardMsg();

const openMap = function (obj) {
  let loc = obj.value;
  console.log(obj.value);
  if (loc != null && loc != 'null' && loc != '' && loc != undefined) {
    let url = `https://www.google.com/maps/@${loc},18z`;
    let x = 50; //screen.width / 2 - 535 / 2;
    let y = 100; //screen.height / 2 - 400 / 2;
    window.open(url, "g_map", `toolbar=no,menubar=no,status=no,titlebar=no,scrollbars=yes,resizable=yes,top=${y},left=${x},width=1200,height=800`);
  }
}


// $(document).ready(function () {

//         $('li a').on('click',function (e) {
//             // e.preventDefault();
//             $('a').removeClass('active');
//             $(this).addClass('active');
//         });

// });

$(document).ready(function () {
  $('ul li a').click(function () {
    $('li a').removeClass("active");
    $(this).addClass("active");
  });
});



/**
 * Find the words of the string
 * @param {String} str 
 * @returns {int} count
 */
function wordCounter(str) {

  str = str.replace(/(^\s*)|(\s*$)/gi, "");
  str = str.replace(/[ ]{2,}/gi, " ");
  str = str.replace(/\n /, "\n");

  if (str != '' || str != null) {
    return str.split(' ').length;
  }

  return 0;
}




function setRemarks2Modal(data) {

  let showData = '';

  let baseUrl = document.getElementById('base_url').value;

  data.forEach((ele, idx) => {

    if (ele.user_type === 'writer' && ele.remark !== null) {

      showData += `<div class="direct-chat-msg">
        <div class="direct-chat-info clearfix">
          <span class="direct-chat-name pull-left">${ele.user_name.username} - ${ele.user_type}</span>
          <span class="direct-chat-timestamp pull-right">${ele.remark_date}</span>
        </div>
        <!-- /.direct-chat-info -->
        <img class="direct-chat-img" src="${baseUrl}/layout/user.png" alt="Message User Image">
        <div class="direct-chat-text bg-success">
          ${ele.remark}
        </div>
      </div>`;

    } else if (ele.user_type === 'leader' && ele.remark !== null) {

      showData += `<div class="direct-chat-msg">
        <div class="direct-chat-info clearfix">
          <span class="direct-chat-name pull-left">${ele.user_name.username} - ${ele.user_type}</span>
          <span class="direct-chat-timestamp pull-right">${ele.remark_date}</span>
        </div>
        <!-- /.direct-chat-info -->
        <img class="direct-chat-img" src="${baseUrl}/layout/user.png" alt="Message User Image">
        <div class="direct-chat-text bg-warning">
          ${ele.remark}
        </div>
      </div>`;

    } else if (ele.user_type === 'seo' && ele.remark !== null) {
      showData += `<div class="direct-chat-msg">
        <div class="direct-chat-info clearfix">
          <span class="direct-chat-name pull-left">${ele.user_name.username} - ${ele.user_type}</span>
          <span class="direct-chat-timestamp pull-right">${ele.remark_date}</span>
        </div>
        <!-- /.direct-chat-info -->
        <img class="direct-chat-img" src="${baseUrl}/layout/user.png" alt="Message User Image">
        <div class="direct-chat-text bg-danger">
          ${ele.remark}
        </div>
      </div>`;
    }

  });
  $("#remarks-modal").modal("show");
  $("#remarks-modal").on('shown.bs.modal', function () {
    $("#remarks-modal .modal-body p").html(showData);
  });
  $("#remarks-modal").on('hidden.bs.modal', function () {
    $("#remarks-modal .modal-body p").html('');
  });
}
$(document).ready(function() {
    $('.nav  li:has(ul)').click(function(e) {
        e.preventDefault();

        if($(this).hasClass('activado')) {
            $(this).removeClass('activado');
            $(this).children('ul').slideUp();
        } else {
            $('.nav  li ul').slideUp();
            $('.nav  li').removeClass('activado');
            $(this).addClass('activado');
            $(this).children('ul').slideDown();
        }

        $('.nav li ul li a').click(function() {
            window.location.href = $(this).attr('href');
        })
    });
});