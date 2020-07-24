@extends('voyager::master')
@section('head')
{{-- <script src="https://unpkg.com/jquery@3.3.1/dist/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script> --}}
<link rel="stylesheet" type="text/css"
    href="https://cdn.jsdelivr.net/npm/vanilla-semantic-ui@0.0.1/dist/vanilla-semantic.min.css">
 <style>
    * {
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    table.ui.table {
      display: none;
      font-size: 30px;
    }

    table.ui.table td {
      cursor: pointer;
    }

    table.ui.table td:hover {
      background-color: rgb(233, 233, 233);
    }
  </style>
@endsection

@section('content')

<div class="container">
    <div id='loader' class="ui dimmer">
    <div class="ui loader"></div>
  </div>
  <div class="ui center aligned stackable grid">
    <div class="row">
      <div class="column" style="padding: 3em 0 !important; ">

        <span id="output-color" class="ui tiny orange circular label"></span>&nbsp;<span class="ui large header"
          id="output-lbl">Ready</span>
      </div>
    </div>
    <div class="row">
      <div class="six wide left aligned column">
        <div class="ui form">
          <div class="field">
            <label>Name</label>
            <div class="ui acion input">
              <input id="client-name" type="text" name="clientName" placeholder="e.g Ejiro_maina" required>
            </div>
          </div>
          <div class="field">
            <button id="login-btn" class="ui positive button">Register</button>
            <button id="logout-btn" class="ui negative button" disabled>Logout</button>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="six wide left aligned column">
        <div class="ui form">
          <div class="field">
            <label>Call</label>
            <div class="ui action input">
              <input type="text" value="" id="call-to" placeholder="Enter phone number to call" disabled>
              <button id="call-btn" class="ui teal right labeled icon button" disabled>
                <i class="phone icon"></i>
                Call
              </button>
            </div>
          </div>
          <div class="field">
            <button id="answer-btn" class="ui positive button" disabled>Answer</button>
            <button id="hangup-btn" class="ui negative button" disabled>Hangup</button>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <table id="dtmf-keyboard" class="ui basi unstackable collapsing celled table">
        <tr>
          <td>1</td>
          <td>2</td>
          <td>3</td>
        </tr>
        <tr>
          <td>4</td>
          <td>5</td>
          <td>6</td>
        </tr>
        <tr>
          <td>7</td>
          <td>8</td>
          <td>9</td>
        </tr>
        <tr>
          <td>*</td>
          <td>0</td>
          <td>#</td>
        </tr>
      </table>
    </div>
  </div>
  {{-- @csrf --}}
  <script src="https://unpkg.com/africastalking-client@1.0.2/build/africastalking.js"></script>

  <script>

  </script>
</div>
<script>
window.onload = function(){
    let clientName = document.getElementById("client-name");
    clientName.value = "{{Auth::user()->name}}";

    // ATlogin();
}
 const username = "TIFACommodityPrices";

    const loginBtn = document.getElementById("login-btn"),
    outputLabel = document.getElementById("output-lbl"),
     loader = document.getElementById("loader");

    loginBtn.addEventListener("click", function () {
    ATlogin();

    });
// console.log({ Africastalking });
function ATlogin() {
    var csrf = document.querySelector('meta[name="csrf-token"]').content;
//  alert(csrf);
  const clientName = document.getElementById("client-name");
  if (!(clientName.value.length === 0)) {
    loader.classList = "ui active dimmer";
    fetch("/api/capability-token", {
      headers: { "Content-Type": "application/json; charset=utf-8" },
      method: "POST",
      body: JSON.stringify({
        clientName: clientName.value,
        _token: csrf
      }),
    })
      .then((data) => {
        console.log(data)
        return data.json();
      })
      .then((response) => {
        let token = response.token;
        console.log(response);
        const at = new Africastalking.Client(token, {
          // sounds: {
          //   dialing: '/sounds/dial.mp3',
          //   ringing: '/sounds/ring.mp3'
          // }
        });
        return at;
      })
      .then((client) => {
          const logoutBtn = document.getElementById("logout-btn"),
          hangupBtn = document.getElementById("hangup-btn"),
          answerBtn = document.getElementById("answer-btn"),
          callBtn = document.getElementById("call-btn"),
          callto = document.getElementById("call-to"),
          outputColor = document.getElementById("output-color"),
          dtmfKeyboard = document.getElementById("dtmf-keyboard");

        logoutBtn.addEventListener("click", function () {
          client.hangup();
          client.logout();
        });

        hangupBtn.addEventListener("click", function () {
          client.hangup();
        });

        answerBtn.addEventListener("click", function () {
          client.answer();
        });

        callBtn.addEventListener("click", function () {
          let to = document.getElementById("call-to").value;
          if (/^[a-zA-Z]+/.test(to)) {
            to = `${username}.${to}`;
          }
          client.call(to, false);
        });

        for (const key of dtmfKeyboard.querySelectorAll("td")) {
          key.addEventListener("click", function (events) {
            const text = events.target.innerHTML;
            client.dtmf(text);
          });
        }

        ////////////////////////webrtc events////////////////////////////

        client.on(
          "ready",
          function () {
            loginBtn.setAttribute("disabled", "disabled");
            clientName.setAttribute("disabled", "disabled");
            logoutBtn.removeAttribute("disabled");
            callto.removeAttribute("disabled");
            callBtn.removeAttribute("disabled");
            callto.focus();
            outputColor.classList = "ui tiny green circular label";
            outputLabel.textContent = "Ready to make calls";
            loader.classList = "ui dimmer";
          },
          false
        );

        client.on(
          "notready",
          function () {
            loginBtn.removeAttribute("disabled");
            clientName.removeAttribute("disabled");
            logoutBtn.setAttribute("disabled", "disabled");
            callto.setAttribute("disabled", "disabled");
            callBtn.setAttribute("disabled", "disabled");
            outputLabel.textContent = "Login";
            outputColor.classList = "ui tiny orange circular label";
          },
          false
        );

        client.on(
          "calling",
          function () {
            hangupBtn.removeAttribute("disabled");
            callto.setAttribute("disabled", "disabled");
            callBtn.setAttribute("disabled", "disabled");
            outputLabel.textContent =
              "Calling " +
              client.getCounterpartNum().replace(`${username}.`, "") +
              "...";
            outputColor.classList = "ui tiny green circular label";
          },
          false
        );

        client.on(
          "incomingcall",
          function (params) {
            hangupBtn.removeAttribute("disabled");
            answerBtn.removeAttribute("disabled");
            callBtn.setAttribute("disabled", "disabled");
            callto.setAttribute("disabled", "disabled");
            outputLabel.textContent =
              "Incoming call from " + params.from.replace(`${username}.`, "");
            outputColor.classList = "ui tiny green circular label";
          },
          false
        );

        client.on(
          "callaccepted",
          function () {
            hangupBtn.removeAttribute("disabled");
            callBtn.setAttribute("disabled", "disabled");
            callto.setAttribute("disabled", "disabled");
            answerBtn.setAttribute("disabled", "disabled");
            dtmfKeyboard.style.display = "initial";
            outputLabel.textContent =
              "In conversation with " +
              client.getCounterpartNum().replace(`${username}.`, "");
            outputColor.classList = "ui tiny green circular label";
          },
          false
        );

        client.on(
          "hangup",
          function () {
            hangupBtn.setAttribute("disabled", "disabled");
            answerBtn.setAttribute("disabled", "disabled");
            callBtn.removeAttribute("disabled");
            callto.removeAttribute("disabled");
            dtmfKeyboard.style.display = "none";
            outputLabel.textContent = "Call ended";
            outputColor.classList = "ui tiny orange circular label";
          },
          false
        );

        //////////////////////add this
        client.on(
          "offline",
          function () {
            outputLabel.textContent = "Token expired, refresh page";
            outputColor.classList = "ui tiny red circular label";
            loader.classList = "ui dimmer";
          },
          false
        );

        client.on(
          "missedcall",
          function () {
            outputLabel.textContent =
              "Missed call from " +
              client.getCounterpartNum().replace(`${username}.`, "");
            outputColor.classList = "ui tiny red circular label";
            loader.classList = "ui dimmer";
          },
          false
        );

        client.on(
          "closed",
          function () {
            outputLabel.textContent = "connection closed, refresh page";
            outputColor.classList = "ui tiny red circular label";
            loader.classList = "ui dimmer";
          },
          false
        );
      })
      .catch((error) => {
        loader.classList = "ui dimmer";
        console.log(error);
      });
  } else {
    outputLabel.textContent = "make sure client name is valid";
  }
}



</script>
@endsection
