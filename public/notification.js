"use strict";
// var totalNewNoti = 0;
var totalNewNoti = getCookie('totalNewNoti');
// console.log("value ", totalNewNoti);

if (totalNewNoti == "") {
  setCookie('totalNewNoti', 0);
}

// if (!checkCookie('totalNewNoti')) {
//   setCookie('totalNewNoti', 0);
// } else {
//   totalNewNoti = getCookie()
// }

const _newNotiCallback = (ele, response) => {
  // console.log();
  // console.log("value ", totalNewNoti);
  // totalNewNoti = getCookie('totalNewNoti');
  if (response.data.new > 0) {

    totalNewNoti = getCookie('totalNewNoti');


    if (response.data.new > totalNewNoti) {
      customnotify("New Notificatoin", "You have new notificatoin from Logelite Pvt. Ltd.");
      // totalNewNoti = response.data.new;
      setCookie('totalNewNoti', response.data.new);
    }

    ele.children().find('span.navbar-badge').html(response.data.new);
    ele.children().find('span.navbar-badge').removeClass('d-none');
    ele.children().find('span.dropdown-header span').html(`${response.data.new} Notifications`);
    ele.children().find('a.new-noti-a span.new-noti-span').html(`${response.data.new} new notifications`);
    ele.children().find('a.new-noti-a span.last-noti-date').html(`${response.data.date}`);
    ele.children().find('a.new-noti-a').removeClass('d-none');
  } else {
    ele.children().find('span.dropdown-header span').html(`No New Notifications`);
    setCookie('totalNewNoti', response.data.new);
  }
}

fetchNewNoti();

function fetchNewNoti() {
  let nnurl = document.getElementById('fetch-new-noti').value;
  let notificationDropdown = $('#notification-dropdown');
  getAjaxData(notificationDropdown, nnurl, _newNotiCallback);
}
setInterval(function () { fetchNewNoti(); }, (1000 * 60 * 5));


document.addEventListener('DOMContentLoaded', function () {
  if (Notification.permission !== "granted") {
    Notification.requestPermission();
  }
});

function customnotify(title, desc) {

  let url = document.getElementById('fetch-view-noti').value;
  let logo = document.getElementById('fetch-noti-logo').value;

  if (Notification.permission !== "granted") {
    Notification.requestPermission();
  } else {
    let notification = new Notification(title, {
      icon: logo,
      body: desc,
    });

    /* Remove the notification from Notification Center when clicked.*/
    notification.onclick = function () {
      window.open(url);
    };

    /* Callback function when the notification is closed. */
    notification.onclose = function () {
      //console.log('Notification closed');
    };

  }
}


function setCookie(cname, cvalue) {
  // const d = new Date();
  // d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  // let expires = "expires=" + d.toUTCString();
  // document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  document.cookie = `${cname}=${cvalue}`;
}


function getCookie(cname) {
  let name = `${cname}=`;
  let ca = document.cookie.split(';');
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}


// function checkCookie(cname) {
//   let user = getCookie(cname);

//   if (user != "") {
//     return true;
//   }

//   return false;

// }