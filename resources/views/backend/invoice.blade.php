<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   
<div class="container mt-6 mb-7">
    <div class="row justify-content-center">
      <div class="col-lg-12 col-xl-7">
        <div class="card">
          <div class="card-body p-5">
            <h2>
              {{-- Hey {{$data->name}} --}}
              AWS
            </h2>
            <p class="fs-sm">
              {{-- This is the receipt for a payment of <strong>$312.00</strong> (USD) you made to Spacial Themes. --}}
            </p>

            <div class="border-top border-gray-200 pt-4 mt-4">
              <div class="row">
                <div class="col-md-6">
                  <div class="text-muted mb-2">Invoice No.</div>
                  <strong>{{$invoiceId}}</strong>
                </div>
                <div class="col-md-6 text-md-end">
                  <div class="text-muted mb-2">Invoice Date</div>
                  <strong>{{$currentDate}}</strong>
                </div>
              </div>
            </div>

            <div class="border-top border-gray-200 mt-4 py-4">
              <div class="row">
                <div class="col-md-6">
                  <div class="text-muted mb-2">Client</div>
                  <strong>
                    {{$data->name}}
                  </strong>
                  <p class="fs-sm">
                  {{$data->document_add}}
                    <br>
                    <a href="#!" class="text-purple">
                        {{$data->email}}
                    </a>
                  </p>
                </div>
                <div class="col-md-6 text-md-end">
                  <div class="text-muted mb-2">Office</div>
                  <strong>
                    AWS
                  </strong>
                  <p class="fs-sm">
                   Agra
                    <br>
                    <a href="#!" class="text-purple">info@aws.com
                    </a>
                  </p>
                </div>
              </div>
            </div>

            <table class="table border-bottom border-gray-200 mt-3">
              <thead>
                <tr>
                  <th scope="col" class="fs-sm text-dark text-uppercase-bold-sm px-0">Description</th>
                  <th scope="col" class="fs-sm text-dark text-uppercase-bold-sm text-end px-0">Amount</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="px-0">Total</td>
                  <td class="text-end px-0">{{$data->total_amount}}</td>
                </tr>
                <tr>
                  <td class="px-0">Recieve</td>
                  <td class="text-end px-0">{{$data->payment_re}}</td>
                </tr>
                <tr>
                    <td class="px-0">Due</td>
                    <td class="text-end px-0">{{$data->payment_due}}</td>
                  </tr>
              </tbody>
            </table>

            <div class="mt-5">
              <div class="d-flex justify-content-end">
                <p class="text-muted me-3">Subtotal:</p>
                <span>&nbsp; {{$data->payment_re}}</span>
              </div>
              <div class="d-flex justify-content-end">
                <p class="text-muted me-3">Discount:</p>
                <span>&nbsp; 0.0</span>
              </div>
              <div class="d-flex justify-content-end mt-3">
                <h5 class="me-3">Total:</h5>
                <h5 class="text-success"> {{$data->payment_re}} </h5>
              </div>
            </div>
          </div>
          <a href="#!" id="printButton" class="btn btn-dark btn-lg card-footer-btn justify-content-center text-uppercase-bold-sm hover-lift-light">
            Print
        </a>        
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    document.getElementById("printButton").addEventListener("click", function() {
        window.print();
    });
    </script>
  
  <style>
     .container {
            max-width: 100%;
            margin: 20px auto;
        }
      @media print {
            body {
                width: 210mm;
                height: 297mm;
                margin: 0; /* Remove default margins */
                padding: 0;
                -webkit-print-color-adjust: exact;
            }
            .print-button, .no-print {
                display: none !important;
            }
            .container {
                width: 100%;
            }
        }

        /* Ensure the container is responsive */
        .container {
            max-width: 100%;
        }
    body{margin-top:20px;
background:#87CEFA;
}

.card-footer-btn {
    display: flex;
    align-items: center;
    border-top-left-radius: 0!important;
    border-top-right-radius: 0!important;
}
.text-uppercase-bold-sm {
    text-transform: uppercase!important;
    font-weight: 500!important;
    letter-spacing: 2px!important;
    font-size: .85rem!important;
}
.hover-lift-light {
    transition: box-shadow .25s ease,transform .25s ease,color .25s ease,background-color .15s ease-in;
}
.justify-content-center {
    justify-content: center!important;
}
.btn-group-lg>.btn, .btn-lg {
    padding: 0.8rem 1.85rem;
    font-size: 1.1rem;
    border-radius: 0.3rem;
}
.btn-dark {
    color: #fff;
    background-color: #1e2e50;
    border-color: #1e2e50;
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(30,46,80,.09);
    border-radius: 0.25rem;
    box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
}

.p-5 {
    padding: 3rem!important;
}
.card-body {
    flex: 1 1 auto;
    padding: 1.5rem 1.5rem;
}

tbody, td, tfoot, th, thead, tr {
    border-color: inherit;
    border-style: solid;
    border-width: 0;
}

.table td, .table th {
    border-bottom: 0;
    border-top: 1px solid #edf2f9;
}
.table>:not(caption)>*>* {
    padding: 1rem 1rem;
    background-color: var(--bs-table-bg);
    border-bottom-width: 1px;
    box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
}
.px-0 {
    padding-right: 0!important;
    padding-left: 0!important;
}
.table thead th, tbody td, tbody th {
    vertical-align: middle;
}
tbody, td, tfoot, th, thead, tr {
    border-color: inherit;
    border-style: solid;
    border-width: 0;
}

.mt-5 {
    margin-top: 3rem!important;
}

.icon-circle[class*=text-] [fill]:not([fill=none]), .icon-circle[class*=text-] svg:not([fill=none]), .svg-icon[class*=text-] [fill]:not([fill=none]), .svg-icon[class*=text-] svg:not([fill=none]) {
    fill: currentColor!important;
}
.svg-icon>svg {
    width: 1.45rem;
    height: 1.45rem;
}
  </style>