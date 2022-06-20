<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Successful at Work Report Portal</title>

  <style>
    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';
      font-size: 1rem;
      font-weight: 400;
      line-height: 1.5;
      color: #212529;
      text-align: left;
      background-color: #ffffff;
      padding: 0;
      /* margin-top: 0; */
      margin-bottom: 0;
      margin-left: auto;
      margin-right: auto;
    }

    .container {
      /* margin-top: 20px; */
      width: 100%;
      max-width: 1000px;
      margin: auto;
    }

    .parent-table {
      width: 100%;
      background-color: #ffffff;
      border: 1px solid #e0e0e0;
      padding: 5px;
    }

    .parent-table thead th {
      text-align: center;

    }

    .parent-table tbody tr:nth-child(odd) {
      background: #f3f3f3;
    }

    .parent-table tbody tr td {
      padding: 10px 0;
    }

    .parent-table tfoot {
      background: #e0e0e0;
      text-align: center;
      font-weight: 600;
      font-style: italic;
      color: darkslategray;
      font-size: 12px;
    }

    .parent-table tfoot tr td {
      padding: 8px 5px;

    }
  </style>
</head>

<body>
  <div class='container'>

    <table class='parent-table' cellpadding='0' cellspacing='0'>
      <thead>
        <tr>
          <th>
            <img src="{{url('')}}/layout/dist/img/logo.png" alt="Logelite">
          </th>
        </tr>
        <tr>
          <th style="border-bottom: 1px solid gray;">
            You are successfully registered on Logelite Work Report Portal.
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Please find login details below.</td>
        </tr>
        <tr>
          <td>
            <strong>Login URL :</strong> <a href="{{url('')}}" target="_blank" rel="noreferrer">{{url('')}}</a>
          </td>
        </tr>
        <tr>
          <td><strong>Username :</strong> {{$details['username']}}</td>
        </tr>
        <tr>
          <td><strong>Password :</strong> {{$details['password']}}</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td>Mailed from Work Report Portal - EMS</td>
        </tr>
      </tfoot>
    </table>
  </div>
</body>

</html>